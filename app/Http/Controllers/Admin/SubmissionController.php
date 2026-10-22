<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DataStatus;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubmissionController extends Controller
{
    public function index(): View
    {
        $submissions = Submission::query()
            ->with(['screeningResult', 'supportingFactor'])
            ->latest('submitted_at')
            ->paginate(20);

        return view('admin.submissions.index', [
            'submissions' => $submissions,
            'counts' => [
                'total' => Submission::query()->count(),
                'valid' => Submission::query()->where('data_status', DataStatus::Valid->value)->count(),
                'excluded' => Submission::query()->where('data_status', DataStatus::Excluded->value)->count(),
            ],
        ]);
    }

    public function show(Submission $submission): View
    {
        $submission->load([
            'consentVersion',
            'dassResponse',
            'supportingFactor',
            'screeningResult.instrumentVersion',
        ]);

        return view('admin.submissions.show', [
            'submission' => $submission,
        ]);
    }

    public function export(): StreamedResponse
    {
        $submissions = Submission::query()
            ->with(['screeningResult', 'supportingFactor'])
            ->where('data_status', DataStatus::Valid->value)
            ->whereNotNull('age_at_submission')
            ->latest('submitted_at')
            ->cursor();

        return response()->streamDownload(function () use ($submissions): void {
            $output = fopen('php://output', 'w');

            if ($output === false) {
                return;
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, [
                'age_years',
                'subdistrict',
                'education_status',
                'employment_status',
                'sleep_duration_hours',
                'physical_activity_days',
                'social_media_hours_per_day',
                'label_depresi',
                'label_kecemasan',
                'label_stres',
            ]);

            foreach ($submissions as $submission) {
                $result = $submission->screeningResult;
                $factors = $submission->supportingFactor;

                if (! $result || ! $factors) {
                    continue;
                }

                fputcsv($output, [
                    $submission->age_at_submission,
                    $submission->subdistrict,
                    $factors->education_status,
                    $factors->employment_status,
                    $factors->sleep_duration_hours,
                    $factors->physical_activity_days,
                    $factors->social_media_hours_per_day,
                    $result->depression_category->value,
                    $result->anxiety_category->value,
                    $result->stress_category->value,
                ]);
            }

            fclose($output);
        }, 'dataset-random-forest-'.now()->format('Ymd-His').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
