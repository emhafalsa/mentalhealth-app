<?php

namespace App\Http\Middleware;

use App\Services\ResearchReadinessService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureQuestionnaireAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $readinessService = app(ResearchReadinessService::class);

        if (! $readinessService->isReady($readinessService->checks())) {
            return redirect()
                ->route('questionnaire.start')
                ->with('questionnaire_error', 'Formulir penelitian belum dibuka.');
        }

        $expiresAt = (int) $request->session()->get('questionnaire.access_until', 0);

        if ($expiresAt < now()->timestamp) {
            $request->session()->forget([
                'questionnaire.access_until',
                'questionnaire.access_method',
            ]);

            return redirect()
                ->route('questionnaire.start')
                ->with('questionnaire_error', 'Akses peserta sudah berakhir. Silakan buka kembali tautan atau masukkan kode akses.');
        }

        return $next($request);
    }
}
