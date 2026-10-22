<?php

namespace App\Http\Controllers;

use App\Enums\DataStatus;
use App\Models\ConsentVersion;
use App\Models\DassResponse;
use App\Models\InstrumentVersion;
use App\Models\ResearchSetting;
use App\Models\Submission;
use App\Services\Dass21Scorer;
use App\Services\ResearchReadinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function start(Request $request, ResearchReadinessService $readinessService): View|RedirectResponse
    {
        $settings = ResearchSetting::current();
        $readiness = $readinessService->checks($settings);

        if (! $readinessService->isReady($readiness)) {
            return view('questionnaire.closed', [
                'settings' => $settings,
                'blockers' => $readinessService->blockers($readiness),
            ]);
        }

        if ($this->hasValidAccess($request)) {
            return redirect()->route('questionnaire.consent');
        }

        if ($settings->access_mode === 'participant_link') {
            return view('questionnaire.link-required');
        }

        return redirect()->route('questionnaire.code');
    }

    public function access(Request $request, ResearchReadinessService $readinessService): RedirectResponse
    {
        if (! $readinessService->isReady($readinessService->checks())) {
            return redirect()->route('questionnaire.start')
                ->with('questionnaire_error', 'Formulir penelitian belum dibuka.');
        }

        $request->session()->put([
            'questionnaire.access_until' => now()->addHours(4)->timestamp,
            'questionnaire.access_method' => 'signed_link',
        ]);

        return redirect()->route('questionnaire.consent');
    }

    public function codeForm(Request $request, ResearchReadinessService $readinessService): View|RedirectResponse
    {
        $settings = ResearchSetting::current();
        $readiness = $readinessService->checks($settings);

        if (! $readinessService->isReady($readiness)) {
            return view('questionnaire.closed', [
                'settings' => $settings,
                'blockers' => $readinessService->blockers($readiness),
            ]);
        }

        if ($this->hasValidAccess($request)) {
            return redirect()->route('questionnaire.consent');
        }

        if ($settings->access_mode === 'participant_link') {
            return redirect()->route('questionnaire.start');
        }

        return view('questionnaire.code');
    }

    public function codeStore(Request $request, ResearchReadinessService $readinessService): RedirectResponse
    {
        $settings = ResearchSetting::current();
        $readiness = $readinessService->checks($settings);

        if (! $readinessService->isReady($readiness) || $settings->access_mode === 'participant_link') {
            return redirect()->route('questionnaire.start');
        }

        $request->validate([
            'access_code' => ['required', 'string', 'max:100'],
        ], [
            'access_code.required' => 'Kode akses wajib diisi.',
        ]);

        if (! $settings->hasAccessCode() || ! Hash::check((string) $request->input('access_code'), (string) $settings->access_code_hash)) {
            throw ValidationException::withMessages([
                'access_code' => 'Kode akses tidak sesuai.',
            ]);
        }

        $request->session()->put([
            'questionnaire.access_until' => now()->addHours(4)->timestamp,
            'questionnaire.access_method' => 'access_code',
        ]);

        return redirect()->route('questionnaire.consent');
    }

    public function consent(Request $request): View|RedirectResponse
    {
        $consent = $this->activeConsent();

        if (! $consent) {
            return redirect()->route('questionnaire.start')
                ->with('questionnaire_error', 'Teks persetujuan belum tersedia.');
        }

        return view('questionnaire.consent', [
            'consent' => $consent,
            'settings' => ResearchSetting::current(),
        ]);
    }

    public function acceptConsent(Request $request): RedirectResponse
    {
        $request->validate([
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Anda harus menyetujui untuk melanjutkan.',
        ]);

        $consent = $this->activeConsent();

        if (! $consent) {
            return redirect()->route('questionnaire.start')
                ->with('questionnaire_error', 'Teks persetujuan belum tersedia.');
        }

        $request->session()->put([
            'questionnaire.consent_version_id' => $consent->getKey(),
            'questionnaire.consent_accepted_at' => now()->toIso8601String(),
        ]);

        return redirect()->route('questionnaire.eligibility');
    }

    public function declineConsent(Request $request): View
    {
        $request->session()->forget([
            'questionnaire.access_until',
            'questionnaire.access_method',
            'questionnaire.consent_version_id',
            'questionnaire.consent_accepted_at',
            'questionnaire.eligibility',
            'questionnaire.nonce',
        ]);

        return view('questionnaire.declined');
    }

    public function eligibility(Request $request): View|RedirectResponse
    {
        if (! $this->hasCurrentConsent($request)) {
            return redirect()->route('questionnaire.consent')
                ->with('questionnaire_error', 'Silakan membaca dan menyetujui lembar persetujuan.');
        }

        return view('questionnaire.eligibility', [
            'settings' => ResearchSetting::current(),
        ]);
    }

    public function storeEligibility(Request $request): View|RedirectResponse
    {
        if (! $this->hasCurrentConsent($request)) {
            return redirect()->route('questionnaire.consent')
                ->with('questionnaire_error', 'Silakan membaca dan menyetujui lembar persetujuan.');
        }

        $settings = ResearchSetting::current();

        if (! in_array($settings->age_verification_method, [
            'date_of_birth',
            'age_years',
            'birth_year_plus_age_confirmation',
        ], true)) {
            return $this->ineligible('Metode verifikasi usia belum ditetapkan oleh peneliti.');
        }

        $rules = [
            'birth_year' => ['required', 'integer', 'between:1900,2100'],
            'subdistrict' => ['nullable', Rule::in(array_keys(config('research.subdistricts', [])))],
            'wonosobo_resident' => ['nullable', 'boolean'],
        ];

        if ($settings->age_verification_method === 'date_of_birth') {
            $rules['date_of_birth'] = ['required', 'date', 'before_or_equal:today'];
        } else {
            $rules['age_years'] = ['required', 'integer', 'min:'.$settings->minimum_age, 'max:120'];
        }

        $data = $request->validate($rules);
        $birthYear = (int) $data['birth_year'];

        if (! $request->boolean('wonosobo_resident')) {
            return $this->ineligible('Formulir ini hanya untuk peserta yang berada di wilayah penelitian Kabupaten Wonosobo.');
        }

        if ($settings->genz_birth_year_start !== null && $birthYear < $settings->genz_birth_year_start) {
            return $this->ineligible('Tahun lahir berada di luar rentang Generasi Z yang ditetapkan.');
        }

        if ($settings->genz_birth_year_end !== null && $birthYear > $settings->genz_birth_year_end) {
            return $this->ineligible('Tahun lahir berada di luar rentang Generasi Z yang ditetapkan.');
        }

        $age = null;

        if (in_array($settings->age_verification_method, ['age_years', 'birth_year_plus_age_confirmation'], true)) {
            $age = (int) $data['age_years'];
        } elseif ($settings->age_verification_method === 'date_of_birth') {
            $dateOfBirth = Carbon::parse((string) $data['date_of_birth']);

            if ($dateOfBirth->year !== $birthYear) {
                return $this->ineligible('Tahun lahir tidak sesuai dengan tanggal lahir yang diisi.');
            }

            $age = $dateOfBirth->age;
        }

        if ($age !== null && $age < (int) $settings->minimum_age) {
            return $this->ineligible('Usia minimal peserta adalah '.$settings->minimum_age.' tahun.');
        }

        if ($settings->age_verification_method === 'birth_year_plus_age_confirmation'
            && abs($age - (now()->year - $birthYear)) > 1) {
            return $this->ineligible('Usia yang dinyatakan tidak sesuai dengan tahun lahir.');
        }

        $request->session()->put('questionnaire.eligibility', [
            'birth_year' => $birthYear,
            'age_at_submission' => $age,
            'subdistrict' => $data['subdistrict'] ?? null,
            'wonosobo_resident' => true,
            'method' => $settings->age_verification_method,
        ]);

        return redirect()->route('questionnaire.form');
    }

    public function form(Request $request): View|RedirectResponse
    {
        $redirect = $this->ensureReadyForForm($request);

        if ($redirect) {
            return $redirect;
        }

        $instrument = $this->activeInstrument();

        if (! $instrument) {
            return redirect()->route('questionnaire.start')
                ->with('questionnaire_error', 'Instrumen penelitian belum siap.');
        }

        if (! $request->session()->has('questionnaire.nonce')) {
            $request->session()->put('questionnaire.nonce', Str::random(40));
        }

        return view('questionnaire.form', [
            'instrument' => $instrument,
            'items' => $instrument->orderedItemTexts(),
            'responseOptions' => $instrument->responseOptions(),
            'features' => collect(config('research.features', []))
                ->filter(fn (array $feature): bool => ($feature['active'] ?? false) && ($feature['source'] ?? null) === 'form'),
            'nonce' => $request->session()->get('questionnaire.nonce'),
        ]);
    }

    public function submit(
        Request $request,
        Dass21Scorer $scorer,
    ): RedirectResponse {
        $redirect = $this->ensureReadyForForm($request);

        if ($redirect) {
            return $redirect;
        }

        $instrument = $this->activeInstrument();

        if (! $instrument) {
            return redirect()->route('questionnaire.start')
                ->with('questionnaire_error', 'Instrumen penelitian belum siap.');
        }

        $rules = [
            'nonce' => ['required', 'string'],
            'items' => ['required', 'array', 'size:21'],
            'items.*' => ['required', 'integer', 'between:0,3'],
        ];

        foreach ($this->activeFeatures() as $key => $feature) {
            if (($feature['type'] ?? null) === 'categorical') {
                $rules["factors.{$key}"] = ['required', Rule::in(array_keys($feature['options'] ?? []))];
            } else {
                $rules["factors.{$key}"] = [
                    'required',
                    'numeric',
                    'min:'.($feature['min'] ?? 0),
                    'max:'.($feature['max'] ?? 100),
                ];
            }
        }

        $data = $request->validate($rules);

        if (! hash_equals((string) $request->session()->get('questionnaire.nonce'), (string) $data['nonce'])) {
            throw ValidationException::withMessages([
                'form' => 'Sesi formulir sudah tidak berlaku. Muat ulang halaman lalu coba lagi.',
            ]);
        }

        $answers = [];

        foreach (range(1, (int) config('dass21.item_count', 21)) as $item) {
            $value = $data['items'][$item] ?? $data['items'][(string) $item] ?? null;

            if ($value === null) {
                throw ValidationException::withMessages([
                    'items' => 'Semua butir DASS-21 wajib dijawab.',
                ]);
            }

            $answers[$item] = (int) $value;
        }

        $consent = $this->activeConsent();
        $consentId = (int) $request->session()->get('questionnaire.consent_version_id');

        if (! $consent || $consent->getKey() !== $consentId) {
            return redirect()->route('questionnaire.consent')
                ->with('questionnaire_error', 'Teks persetujuan berubah. Silakan membaca dan menyetujui versi terbaru.');
        }

        $eligibility = $request->session()->get('questionnaire.eligibility');

        if (! is_array($eligibility) || ! isset($eligibility['birth_year'])) {
            return redirect()->route('questionnaire.eligibility')
                ->with('questionnaire_error', 'Data kelayakan belum lengkap.');
        }

        $score = $scorer->score($answers);
        $consentAcceptedAt = Carbon::parse((string) $request->session()->get('questionnaire.consent_accepted_at'));

        DB::transaction(function () use ($data, $eligibility, $consent, $consentAcceptedAt, $instrument, $score, $answers): void {
            $submission = Submission::query()->create([
                'birth_year' => $eligibility['birth_year'],
                'age_at_submission' => $eligibility['age_at_submission'],
                'subdistrict' => $eligibility['subdistrict'] ?? null,
                'wonosobo_resident' => true,
                'eligible' => true,
                'consent_version_id' => $consent->getKey(),
                'consent_accepted_at' => $consentAcceptedAt,
                'data_status' => DataStatus::Valid,
                'submitted_at' => now(),
            ]);

            $response = [];

            foreach ($answers as $item => $value) {
                $response[DassResponse::itemColumn($item)] = $value;
            }

            $submission->dassResponse()->create($response);

            $submission->supportingFactor()->create([
                'education_status' => $data['factors']['education_status'],
                'employment_status' => $data['factors']['employment_status'],
                'sleep_duration_hours' => $data['factors']['sleep_duration_hours'],
                'physical_activity_days' => $data['factors']['physical_activity_days'],
                'social_media_hours_per_day' => $data['factors']['social_media_hours_per_day'],
                'social_support_score' => null,
            ]);

            $submission->screeningResult()->create([
                'instrument_version_id' => $instrument->getKey(),
                'depression_raw' => $score->depression->raw,
                'depression_final' => $score->depression->final,
                'depression_category' => $score->depression->category,
                'anxiety_raw' => $score->anxiety->raw,
                'anxiety_final' => $score->anxiety->final,
                'anxiety_category' => $score->anxiety->category,
                'stress_raw' => $score->stress->raw,
                'stress_final' => $score->stress->final,
                'stress_category' => $score->stress->category,
                'computed_at' => now(),
            ]);
        });

        $request->session()->forget([
            'questionnaire.access_until',
            'questionnaire.access_method',
            'questionnaire.consent_version_id',
            'questionnaire.consent_accepted_at',
            'questionnaire.eligibility',
            'questionnaire.nonce',
        ]);
        $request->session()->put('questionnaire.completed', true);

        return redirect()->route('questionnaire.complete');
    }

    public function complete(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('questionnaire.completed')) {
            return redirect()->route('questionnaire.start');
        }

        return view('questionnaire.complete');
    }

    private function hasValidAccess(Request $request): bool
    {
        return (int) $request->session()->get('questionnaire.access_until', 0) >= now()->timestamp;
    }

    private function activeConsent(): ?ConsentVersion
    {
        return ConsentVersion::query()
            ->active()
            ->latest('effective_from')
            ->first();
    }

    private function hasCurrentConsent(Request $request): bool
    {
        $consent = $this->activeConsent();

        return $consent !== null
            && (int) $request->session()->get('questionnaire.consent_version_id') === $consent->getKey();
    }

    private function activeInstrument(): ?InstrumentVersion
    {
        $instrument = InstrumentVersion::query()->active()->first();

        return $instrument?->hasCompleteItemTexts() ? $instrument : null;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function activeFeatures(): array
    {
        return collect(config('research.features', []))
            ->filter(fn (array $feature): bool => ($feature['active'] ?? false) && ($feature['source'] ?? null) === 'form')
            ->all();
    }

    private function ensureReadyForForm(Request $request): ?RedirectResponse
    {
        $readinessService = app(ResearchReadinessService::class);

        if (! $readinessService->isReady($readinessService->checks())) {
            return redirect()->route('questionnaire.start')
                ->with('questionnaire_error', 'Formulir penelitian belum dibuka.');
        }

        if (! $this->hasCurrentConsent($request)) {
            return redirect()->route('questionnaire.consent')
                ->with('questionnaire_error', 'Silakan menyetujui lembar persetujuan terlebih dahulu.');
        }

        $eligibility = $request->session()->get('questionnaire.eligibility');

        if (! is_array($eligibility) || ($eligibility['wonosobo_resident'] ?? false) !== true) {
            return redirect()->route('questionnaire.eligibility')
                ->with('questionnaire_error', 'Lengkapi pemeriksaan kelayakan terlebih dahulu.');
        }

        return null;
    }

    private function ineligible(string $reason): View
    {
        return view('questionnaire.ineligible', [
            'reason' => $reason,
        ]);
    }
}
