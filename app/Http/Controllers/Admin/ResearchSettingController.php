<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResearchSettingRequest;
use App\Models\ResearchSetting;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class ResearchSettingController extends Controller
{
    public function update(ResearchSettingRequest $request, AuditLogger $auditLogger): RedirectResponse
    {
        $settings = ResearchSetting::current();
        $data = $request->validated();
        $accessCode = $data['access_code'] ?? null;
        unset($data['access_code']);

        if (filled($accessCode)) {
            $data['access_code_hash'] = Hash::make((string) $accessCode);
        }

        if ($request->boolean('remove_access_code')) {
            $data['access_code_hash'] = null;
        }

        unset($data['remove_access_code']);

        $settings->fill($data);
        $settings->updated_by = $request->user()?->getKey();
        $settings->save();

        $changes = $settings->getChanges();
        unset($changes['updated_at']);

        $auditLogger->record('research_settings.updated', $settings, [
            'fields' => array_keys($changes),
        ]);

        return redirect()
            ->route('admin.setup.index')
            ->with('status', 'Pengaturan penelitian diperbarui.');
    }
}
