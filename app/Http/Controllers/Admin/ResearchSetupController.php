<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsentVersion;
use App\Models\InstrumentVersion;
use App\Models\ResearchSetting;
use App\Services\ResearchReadinessService;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class ResearchSetupController extends Controller
{
    public function __invoke(ResearchReadinessService $readinessService): View
    {
        $settings = ResearchSetting::current();
        $readiness = $readinessService->checks($settings);
        $consents = ConsentVersion::query()->latest()->get();

        return view('admin.setup.index', [
            'settings' => $settings,
            'instruments' => InstrumentVersion::query()->latest()->get(),
            'consents' => $consents,
            'consentPlaceholders' => $consents->mapWithKeys(
                fn (ConsentVersion $consent): array => [
                    $consent->getKey() => $readinessService->hasUnresolvedConsentPlaceholders($consent->body),
                ],
            ),
            'readiness' => $readiness,
            'ready' => $readinessService->isReady($readiness),
            'blockers' => $readinessService->blockers($readiness),
            'participantLink' => $readinessService->isReady($readiness)
                && $settings->access_mode === 'participant_link'
                    ? URL::temporarySignedRoute('questionnaire.access', now()->addDays(7))
                    : null,
            'accessCodeConfigured' => $settings->hasAccessCode(),
        ]);
    }
}
