<?php

namespace App\Services;

use App\Models\ConsentVersion;
use App\Models\InstrumentVersion;
use App\Models\ResearchSetting;

final class ResearchReadinessService
{
    /**
     * @return array<string, bool>
     */
    public function checks(?ResearchSetting $settings = null): array
    {
        $settings ??= ResearchSetting::current();

        $instrument = InstrumentVersion::query()->active()->first();
        $consent = ConsentVersion::query()->active()->first();
        $socialSupportActive = (bool) config('research.features.social_support_score.active', false);
        $socialSupportModelFeature = (bool) config('research.features.social_support_score.model_feature', false);

        return [
            'instrument' => $instrument !== null,
            'instrument_items' => $instrument !== null && $instrument->hasCompleteItemTexts(),
            'consent' => $consent !== null,
            'consent_placeholders' => $consent !== null && ! $this->hasUnresolvedConsentPlaceholders($consent->body),
            'genz' => $settings->hasOperationalGenZRange(),
            'age_verification' => filled($settings->age_verification_method),
            'region' => filled($settings->region_definition),
            'access' => filled($settings->access_mode) && $settings->access_mode !== 'public',
            'access_credentials' => $settings->access_mode === 'participant_link'
                || ($settings->access_mode !== null && $settings->hasAccessCode()),
            'ethics' => in_array($settings->ethics_confirmation_status, ['confirmed', 'not_required'], true),
            'retention' => $settings->retention_months !== null,
            'deletion' => filled($settings->deletion_procedure),
            'mspss' => ! $socialSupportActive && ! $socialSupportModelFeature,
        ];
    }

    /**
     * @param  array<string, bool>  $checks
     */
    public function isReady(array $checks): bool
    {
        return ! in_array(false, $checks, true);
    }

    /**
     * @param  array<string, bool>  $checks
     * @return array<int, string>
     */
    public function blockers(array $checks): array
    {
        $labels = [
            'instrument' => 'Instrumen DASS-21 belum aktif',
            'instrument_items' => 'Teks 21 butir DASS-21 belum lengkap',
            'consent' => 'Teks persetujuan belum aktif',
            'consent_placeholders' => 'Teks persetujuan masih memuat placeholder',
            'genz' => 'Rentang lahir operasional belum 1997-2008',
            'age_verification' => 'Metode verifikasi usia belum ditetapkan',
            'region' => 'Definisi lokasi penelitian belum ditetapkan',
            'access' => 'Mode akses formulir belum dibatasi untuk peserta',
            'access_credentials' => 'Kode akses peserta belum diatur',
            'ethics' => 'Konfirmasi prosedur etik belum dicatat',
            'retention' => 'Masa penyimpanan data belum ditetapkan',
            'deletion' => 'Prosedur penghapusan data belum ditetapkan',
            'mspss' => 'Instrumen pendukung sosial belum boleh diaktifkan',
        ];

        $blockers = [];

        foreach ($checks as $key => $passed) {
            if (! $passed) {
                $blockers[] = $labels[$key] ?? $key;
            }
        }

        return $blockers;
    }

    public function hasUnresolvedConsentPlaceholders(string $body): bool
    {
        foreach (config('research.consent_required_placeholders', []) as $placeholder) {
            if (str_contains($body, $placeholder)) {
                return true;
            }
        }

        return (bool) preg_match('/\[[^\]]+\]/', $body);
    }
}
