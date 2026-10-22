<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ConsentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConsentVersionRequest;
use App\Models\ConsentVersion;
use App\Services\AuditLogger;
use App\Services\ResearchReadinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ConsentVersionController extends Controller
{
    public function create(): View
    {
        return view('admin.setup.consents.form', [
            'consent' => new ConsentVersion([
                'status' => ConsentStatus::Draft,
            ]),
        ]);
    }

    public function store(
        ConsentVersionRequest $request,
        AuditLogger $auditLogger,
    ): RedirectResponse {
        $data = $request->validated();
        $data['is_active'] = false;
        $data['created_by'] = $request->user()?->getKey();
        $data['verified_at'] = $data['status'] === ConsentStatus::ApprovedForUse->value ? now() : null;
        $data['verified_by'] = $data['status'] === ConsentStatus::ApprovedForUse->value
            ? $request->user()?->getKey()
            : null;

        $consent = ConsentVersion::query()->create($data);

        $auditLogger->record('consent_version.created', $consent, [
            'version' => $consent->version,
            'status' => $consent->status->value,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Versi persetujuan dibuat.');
    }

    public function edit(ConsentVersion $consent): View|RedirectResponse
    {
        if ($consent->is_active) {
            return redirect()
                ->route('admin.setup.index')
                ->withErrors(['consent' => 'Nonaktifkan teks persetujuan sebelum mengubahnya.']);
        }

        return view('admin.setup.consents.form', [
            'consent' => $consent,
        ]);
    }

    public function update(
        ConsentVersionRequest $request,
        ConsentVersion $consent,
        AuditLogger $auditLogger,
    ): RedirectResponse {
        if ($consent->is_active) {
            return redirect()
                ->route('admin.setup.index')
                ->withErrors(['consent' => 'Nonaktifkan teks persetujuan sebelum mengubahnya.']);
        }

        $oldStatus = $consent->status;
        $consent->fill($request->validated());

        if ($consent->status === ConsentStatus::ApprovedForUse) {
            $consent->verified_at ??= now();
            $consent->verified_by = $request->user()?->getKey();
        } else {
            $consent->verified_at = null;
            $consent->verified_by = null;
        }

        $consent->save();

        $auditLogger->record('consent_version.updated', $consent, [
            'version' => $consent->version,
            'old_status' => $oldStatus->value,
            'new_status' => $consent->status->value,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Teks persetujuan diperbarui.');
    }

    public function activate(
        ConsentVersion $consent,
        AuditLogger $auditLogger,
        ResearchReadinessService $readinessService,
    ): RedirectResponse {
        $errors = $this->activationErrors($consent, $readinessService);

        if ($errors !== []) {
            return redirect()
                ->route('admin.setup.index')
                ->withErrors(['consent' => $errors]);
        }

        DB::transaction(function () use ($consent): void {
            ConsentVersion::query()
                ->whereKeyNot($consent->getKey())
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                ]);

            $consent->forceFill([
                'status' => ConsentStatus::ApprovedForUse,
                'is_active' => true,
                'effective_from' => $consent->effective_from ?? now(),
            ])->save();
        });

        $auditLogger->record('consent_version.activated', $consent, [
            'version' => $consent->version,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Teks persetujuan diaktifkan.');
    }

    public function deactivate(ConsentVersion $consent, AuditLogger $auditLogger): RedirectResponse
    {
        $consent->forceFill([
            'status' => ConsentStatus::ApprovedForUse,
            'is_active' => false,
        ])->save();

        $auditLogger->record('consent_version.deactivated', $consent, [
            'version' => $consent->version,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Teks persetujuan dinonaktifkan.');
    }

    /**
     * @return array<int, string>
     */
    private function activationErrors(
        ConsentVersion $consent,
        ResearchReadinessService $readinessService,
    ): array {
        if ($consent->status !== ConsentStatus::ApprovedForUse) {
            return ['Teks persetujuan harus berstatus disetujui untuk digunakan sebelum diaktifkan.'];
        }

        if ($consent->verified_at === null) {
            return ['Tanggal verifikasi belum tersedia.'];
        }

        if ($readinessService->hasUnresolvedConsentPlaceholders($consent->body)) {
            return ['Teks persetujuan masih memuat placeholder.'];
        }

        return [];
    }
}
