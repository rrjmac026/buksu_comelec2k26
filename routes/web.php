<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCandidateController;
use App\Http\Controllers\Admin\AdminCollegeController;
use App\Http\Controllers\Admin\AdminOrganizationController;
use App\Http\Controllers\Admin\AdminPartylistController;
use App\Http\Controllers\Admin\AdminPositionController;
use App\Http\Controllers\Admin\AdminCastedVoteController;
use App\Http\Controllers\Admin\AdminVoterController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminElectionController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\DataBackupController;
use App\Http\Controllers\Admin\AdminActivityLogController;
use App\Http\Controllers\Admin\AdminSettingsController;

use App\Http\Controllers\Voter\VoterDashboardController;
use App\Http\Controllers\Voter\VoterCastedVoteController;
use App\Http\Controllers\Voter\VoterFeedbackController;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/public/stats', [PublicController::class, 'stats'])->name('public.stats');
Route::view('/elections', 'public.elections')->name('public.elections');
Route::view('/how-it-works', 'public.how-it-works')->name('public.how-it-works');
Route::view('/contact', 'public.contact')->name('public.contact');
Route::view('/about', 'public.about')->name('public.about');


/*
|--------------------------------------------------------------------------
| Authenticated (shared) Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))
        ->middleware('verified')
        ->name('dashboard');


});
Route::get('auth/google',          [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/',    [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/',  [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

        // Dashboard
        Route::get('dashboard',      [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard/live', [AdminDashboardController::class, 'live'])->name('dashboard.live');

        // Election Setup
        Route::get('/admin/students/search', [AdminCandidateController::class, 'searchStudent'])
            ->name('students.search');
        Route::resource('candidates',    AdminCandidateController::class);
        Route::resource('positions',     AdminPositionController::class);
        Route::resource('partylists',    AdminPartylistController::class);
        Route::resource('organizations', AdminOrganizationController::class);
        Route::resource('colleges',      AdminCollegeController::class);

        // Voters
        Route::patch('voters/{voter}/status', [AdminVoterController::class, 'toggleStatus'])
            ->name('voters.toggle-status');
        Route::resource('voters', AdminVoterController::class);

        // Votes & Results
        Route::get('votes/results', [AdminCastedVoteController::class, 'results'])->name('votes.results');
        Route::delete('votes/transaction/{transaction}', [AdminCastedVoteController::class, 'destroyTransaction'])
            ->name('votes.destroyTransaction');
        Route::resource('votes', AdminCastedVoteController::class);

        // Feedback (read-only)
        Route::resource('feedback', AdminFeedbackController::class)
            ->only(['index', 'show', 'destroy']);

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',           fn() => view('admin.reports.index'))->name('index');
            Route::get('/results',    [AdminReportController::class, 'results'])->name('results');
            Route::get('/by-college', [AdminReportController::class, 'byCollege'])->name('by-college');
            Route::get('/turnout',    [AdminReportController::class, 'turnout'])->name('turnout');
            Route::get('/ballots',    [AdminReportController::class, 'ballots'])->name('ballots');
            Route::get('/candidates', [AdminReportController::class, 'candidates'])->name('candidates');
            Route::get('/feedback',   [AdminReportController::class, 'feedback'])->name('feedback');
        });


        Route::get('activity-logs',      [AdminActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('activity-logs/live', [AdminActivityLogController::class, 'live'])->name('activity-logs.live');

        Route::prefix('settings')->name('settings.')->group(function () {
 
            // Main page (tab=election | tab=backups)
            Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
            Route::post('/election/schedule', [AdminSettingsController::class, 'updateSchedule'])
                ->name('election.schedule');
        
            // Election sub-routes
            Route::post('/election/status', [AdminSettingsController::class, 'updateStatus'])->name('election.status');
            Route::post('/election/name',   [AdminSettingsController::class, 'updateName'])->name('election.name');
        
            // Backup sub-routes
            Route::prefix('backups')->name('backups.')->group(function () {
                Route::post('/',                  [AdminSettingsController::class, 'storeBackup'])->name('store');
                Route::get('/{backup}/download',  [AdminSettingsController::class, 'downloadBackup'])->name('download');
                Route::delete('/{backup}',        [AdminSettingsController::class, 'destroyBackup'])->name('destroy');
                Route::post('/cleanup',           [AdminSettingsController::class, 'cleanupBackups'])->name('cleanup');
                Route::get('/{backup}/status',    [AdminSettingsController::class, 'backupStatus'])->name('status');
                Route::get('/test-system',        [AdminSettingsController::class, 'testSystem'])->name('test');
                Route::post('/quick-backup',      [AdminSettingsController::class, 'quickBackup'])->name('quick');
                Route::get('/statistics',         [AdminSettingsController::class, 'backupStatistics'])->name('statistics');
            });
        
        });

});

/*
|--------------------------------------------------------------------------
| Voter Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'voter', 'election.status'])->prefix('voter')->name('voter.')->group(function () {
 
    // Dashboard
    Route::get('/dashboard',    [VoterDashboardController::class, 'index'])->name('dashboard');
    // Route::get('/results',      [VoterDashboardController::class, 'results'])->name('results');
    // Route::get('/results/live', [VoterDashboardController::class, 'liveResults'])->name('results.live');
 
    // ── Multi-step Ballot ──────────────────────────────────────────
    Route::get('/vote',               [VoterCastedVoteController::class, 'intro'])->name('vote.intro');
    Route::get('/vote/step/{step}',   [VoterCastedVoteController::class, 'step'])->name('vote.step');
    Route::post('/vote/step/{step}',  [VoterCastedVoteController::class, 'saveStep'])->name('vote.step.save');
    Route::get('/vote/review',        [VoterCastedVoteController::class, 'review'])->name('vote.review');
    Route::post('/vote',              [VoterCastedVoteController::class, 'store'])->name('vote.store');
    Route::get('/vote/success',       [VoterCastedVoteController::class, 'success'])->name('vote.success');
    Route::get('/vote/details', [VoterCastedVoteController::class, 'details'])->name('vote.details');
    // ──────────────────────────────────────────────────────────────
 
    // Feedback
    Route::get('/feedback',     [VoterFeedbackController::class, 'show'])->name('feedback');
    Route::post('/feedback',    [VoterFeedbackController::class, 'submit'])->name('feedback.submit');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (login, register, password reset, etc.)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';