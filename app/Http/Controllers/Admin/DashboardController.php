<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DataStatus;
use App\Enums\ModelExperimentStatus;
use App\Http\Controllers\Controller;
use App\Models\ModelExperiment;
use App\Models\ResearchSetting;
use App\Models\Submission;
use App\Services\ResearchReadinessService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(ResearchReadinessService $readinessService): View
    {
        $counts = [
            'total' => Submission::query()->count(),
            'valid' => Submission::query()
                ->where('data_status', DataStatus::Valid->value)
                ->count(),
            'excluded' => Submission::query()
                ->where('data_status', DataStatus::Excluded->value)
                ->count(),
        ];

        $latestExperiment = ModelExperiment::query()
            ->latest('created_at')
            ->first();

        $latestSuccessfulExperiment = ModelExperiment::query()
            ->where('status', ModelExperimentStatus::Succeeded->value)
            ->latest('finished_at')
            ->first();

        $settings = ResearchSetting::current();
        $readiness = $readinessService->checks($settings);

        return view('admin.dashboard', [
            'counts' => $counts,
            'latestExperiment' => $latestExperiment,
            'latestSuccessfulExperiment' => $latestSuccessfulExperiment,
            'experimentCount' => ModelExperiment::query()->count(),
            'settings' => $settings,
            'readiness' => $readiness,
            'ready' => $readinessService->isReady($readiness),
            'blockers' => $readinessService->blockers($readiness),
        ]);
    }
}
