<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InstrumentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstrumentVersionRequest;
use App\Models\InstrumentVersion;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InstrumentVersionController extends Controller
{
    public function create(): View
    {
        return view('admin.setup.instruments.form', [
            'instrument' => new InstrumentVersion([
                'code' => 'dass21',
                'locale' => 'id',
                'status' => InstrumentStatus::Draft,
            ]),
        ]);
    }

    public function store(InstrumentVersionRequest $request, AuditLogger $auditLogger): RedirectResponse
    {
        $data = $request->validated();
        $data['item_texts'] = $request->itemTextLines() ?: null;
        $data['response_options'] = config('dass21.response_options');
        $data['instructions'] = filled($data['instructions'] ?? null)
            ? $data['instructions']
            : config('dass21.instructions');
        unset($data['item_texts_raw']);
        $data['item_subscale_map'] = config('dass21.item_subscale_map');
        $data['severity_thresholds'] = config('dass21.severity_thresholds');
        $data['response_scale'] = config('dass21.response_values');
        $data['is_active'] = false;
        $data['created_by'] = $request->user()?->getKey();
        $data['verified_at'] = $data['status'] === InstrumentStatus::Verified->value ? now() : null;
        $data['verified_by'] = $data['status'] === InstrumentStatus::Verified->value
            ? $request->user()?->getKey()
            : null;

        $instrument = InstrumentVersion::query()->create($data);

        $auditLogger->record('instrument_version.created', $instrument, [
            'code' => $instrument->code,
            'version' => $instrument->version,
            'status' => $instrument->status->value,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Versi instrumen dibuat.');
    }

    public function edit(InstrumentVersion $instrument): View|RedirectResponse
    {
        if ($instrument->is_active) {
            return redirect()
                ->route('admin.setup.index')
                ->withErrors(['instrument' => 'Nonaktifkan instrumen sebelum mengubahnya.']);
        }

        return view('admin.setup.instruments.form', [
            'instrument' => $instrument,
        ]);
    }

    public function update(
        InstrumentVersionRequest $request,
        InstrumentVersion $instrument,
        AuditLogger $auditLogger,
    ): RedirectResponse {
        if ($instrument->is_active) {
            return redirect()
                ->route('admin.setup.index')
                ->withErrors(['instrument' => 'Nonaktifkan instrumen sebelum mengubahnya.']);
        }

        $oldStatus = $instrument->status;
        $data = $request->validated();
        $itemTexts = $request->itemTextLines();

        if ($itemTexts !== []) {
            $data['item_texts'] = $itemTexts;
        }

        $data['response_options'] = $instrument->response_options
            ?: config('dass21.response_options');
        $data['instructions'] = filled($data['instructions'] ?? null)
            ? $data['instructions']
            : $instrument->instructionsText();

        unset($data['item_texts_raw']);

        $instrument->fill($data);

        if ($instrument->status === InstrumentStatus::Verified) {
            $instrument->verified_at ??= now();
            $instrument->verified_by = $request->user()?->getKey();
        } else {
            $instrument->verified_at = null;
            $instrument->verified_by = null;
        }

        $instrument->save();

        $auditLogger->record('instrument_version.updated', $instrument, [
            'version' => $instrument->version,
            'old_status' => $oldStatus->value,
            'new_status' => $instrument->status->value,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Versi instrumen diperbarui.');
    }

    public function activate(InstrumentVersion $instrument, AuditLogger $auditLogger): RedirectResponse
    {
        $errors = $this->activationErrors($instrument);

        if ($errors !== []) {
            return redirect()
                ->route('admin.setup.index')
                ->withErrors(['instrument' => $errors]);
        }

        DB::transaction(function () use ($instrument): void {
            InstrumentVersion::query()
                ->where('code', $instrument->code)
                ->where('locale', $instrument->locale)
                ->whereKeyNot($instrument->getKey())
                ->update([
                    'status' => InstrumentStatus::Verified->value,
                    'is_active' => false,
                ]);

            $instrument->forceFill([
                'status' => InstrumentStatus::Active,
                'is_active' => true,
                'effective_from' => $instrument->effective_from ?? now(),
            ])->save();
        });

        $auditLogger->record('instrument_version.activated', $instrument, [
            'code' => $instrument->code,
            'version' => $instrument->version,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Instrumen diaktifkan.');
    }

    public function deactivate(InstrumentVersion $instrument, AuditLogger $auditLogger): RedirectResponse
    {
        $instrument->forceFill([
            'status' => InstrumentStatus::Verified,
            'is_active' => false,
        ])->save();

        $auditLogger->record('instrument_version.deactivated', $instrument, [
            'code' => $instrument->code,
            'version' => $instrument->version,
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Instrumen dinonaktifkan.');
    }

    /**
     * @return array<int, string>
     */
    private function activationErrors(InstrumentVersion $instrument): array
    {
        if ($instrument->status !== InstrumentStatus::Verified) {
            return ['Instrumen harus berstatus terverifikasi sebelum diaktifkan.'];
        }

        $errors = [];

        foreach ([
            'source_reference' => 'Referensi sumber',
            'source_url' => 'URL sumber',
            'translator' => 'Penerjemah',
            'copyright_status' => 'Status penggunaan',
        ] as $field => $label) {
            if (blank($instrument->{$field})) {
                $errors[] = "{$label} belum diisi.";
            }
        }

        if ($instrument->source_retrieved_at === null) {
            $errors[] = 'Tanggal pengambilan sumber belum diisi.';
        }

        if ($instrument->verified_at === null) {
            $errors[] = 'Tanggal verifikasi belum tersedia.';
        }

        if (empty($instrument->item_subscale_map) || empty($instrument->severity_thresholds)) {
            $errors[] = 'Pemetaan butir atau ambang skor belum tersedia.';
        }

        if (! $instrument->hasCompleteItemTexts()) {
            $errors[] = 'Teks 21 butir DASS-21 belum lengkap.';
        }

        return $errors;
    }
}
