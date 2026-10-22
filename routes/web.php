<?php

use App\Http\Controllers\Admin\ConsentVersionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InstrumentVersionController;
use App\Http\Controllers\Admin\ResearchSettingController;
use App\Http\Controllers\Admin\ResearchSetupController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::prefix('kuesioner')->name('questionnaire.')->group(function (): void {
    Route::get('/', [QuestionnaireController::class, 'start'])->name('start');
    Route::get('/akses', [QuestionnaireController::class, 'access'])
        ->middleware('signed')
        ->name('access');
    Route::get('/masuk', [QuestionnaireController::class, 'codeForm'])->name('code');
    Route::post('/masuk', [QuestionnaireController::class, 'codeStore'])
        ->middleware('throttle:10,1')
        ->name('code.store');

    Route::middleware('questionnaire.access')->group(function (): void {
        Route::get('/persetujuan', [QuestionnaireController::class, 'consent'])->name('consent');
        Route::post('/persetujuan', [QuestionnaireController::class, 'acceptConsent'])
            ->name('consent.store');
        Route::post('/persetujuan/tolak', [QuestionnaireController::class, 'declineConsent'])
            ->name('consent.decline');
        Route::get('/kelayakan', [QuestionnaireController::class, 'eligibility'])->name('eligibility');
        Route::post('/kelayakan', [QuestionnaireController::class, 'storeEligibility'])
            ->name('eligibility.store');
        Route::get('/formulir', [QuestionnaireController::class, 'form'])->name('form');
        Route::post('/formulir', [QuestionnaireController::class, 'submit'])
            ->name('submit');
    });

    Route::get('/selesai', [QuestionnaireController::class, 'complete'])->name('complete');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'admin'])
    ->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/export', [SubmissionController::class, 'export'])->name('submissions.export');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');

    Route::get('/setup', ResearchSetupController::class)->name('setup.index');
    Route::put('/setup/research', [ResearchSettingController::class, 'update'])
        ->name('setup.research.update');

    Route::get('/setup/instruments/create', [InstrumentVersionController::class, 'create'])
        ->name('instruments.create');
    Route::post('/setup/instruments', [InstrumentVersionController::class, 'store'])
        ->name('instruments.store');
    Route::get('/setup/instruments/{instrument}/edit', [InstrumentVersionController::class, 'edit'])
        ->name('instruments.edit');
    Route::put('/setup/instruments/{instrument}', [InstrumentVersionController::class, 'update'])
        ->name('instruments.update');
    Route::post('/setup/instruments/{instrument}/activate', [InstrumentVersionController::class, 'activate'])
        ->name('instruments.activate');
    Route::post('/setup/instruments/{instrument}/deactivate', [InstrumentVersionController::class, 'deactivate'])
        ->name('instruments.deactivate');

    Route::get('/setup/consents/create', [ConsentVersionController::class, 'create'])
        ->name('consents.create');
    Route::post('/setup/consents', [ConsentVersionController::class, 'store'])
        ->name('consents.store');
    Route::get('/setup/consents/{consent}/edit', [ConsentVersionController::class, 'edit'])
        ->name('consents.edit');
    Route::put('/setup/consents/{consent}', [ConsentVersionController::class, 'update'])
        ->name('consents.update');
    Route::post('/setup/consents/{consent}/activate', [ConsentVersionController::class, 'activate'])
        ->name('consents.activate');
    Route::post('/setup/consents/{consent}/deactivate', [ConsentVersionController::class, 'deactivate'])
        ->name('consents.deactivate');
});
