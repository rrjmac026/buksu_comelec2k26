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

use App\Http\Controllers\Voter\VoterDashboardController;
use App\Http\Controllers\Voter\VoterCastedVoteController;
use App\Http\Controllers\Voter\VoterFeedbackController;

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated (shared) Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))
        ->middleware('verified')
        ->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',     [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/',   [ProfileController::class, 'update'])->name('update');
        Route::delete('/',  [ProfileController::class, 'destroy'])->name('destroy');
    });

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

        // Dashboard
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard/live', [AdminDashboardController::class, 'live'])->name('dashboard.live');

        // Election Setup
        Route::resource('candidates',   AdminCandidateController::class);
        Route::resource('positions',    AdminPositionController::class);
        Route::resource('partylists',   AdminPartylistController::class);
        Route::resource('organizations',AdminOrganizationController::class);
        Route::resource('colleges',     AdminCollegeController::class);
        Route::resource('feedback', AdminFeedbackController::class)->only(['index', 'show', 'destroy']);

        // Voters
        Route::patch('voters/{voter}/status', [AdminVoterController::class, 'toggleStatus'])
            ->name('voters.toggle-status');
        Route::resource('voters', AdminVoterController::class);

        // Votes & Results
        Route::get('votes/results', [AdminCastedVoteController::class, 'results'])->name('votes.results');
        Route::resource('votes', AdminCastedVoteController::class);

        // Feedback (read-only for admins)
        Route::resource('feedback', AdminFeedbackController::class)
            ->only(['index', 'show', 'destroy']);

    });

/*
|--------------------------------------------------------------------------
| Voter Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'voter'])->prefix('voter')->name('voter.')->group(function () {
 
    // Dashboard
    Route::get('/dashboard',    [VoterDashboardController::class, 'index'])->name('dashboard');
    Route::get('/results',      [VoterDashboardController::class, 'results'])->name('results');
    Route::get('/results/live', [VoterDashboardController::class, 'liveResults'])->name('results.live');
 
    // ── Multi-step Ballot ──────────────────────────────────────────
    Route::get('/vote',               [VoterCastedVoteController::class, 'intro'])->name('vote.intro');
    Route::get('/vote/step/{step}',   [VoterCastedVoteController::class, 'step'])->name('vote.step');
    Route::post('/vote/step/{step}',  [VoterCastedVoteController::class, 'saveStep'])->name('vote.step.save');
    Route::get('/vote/review',        [VoterCastedVoteController::class, 'review'])->name('vote.review');
    Route::post('/vote',              [VoterCastedVoteController::class, 'store'])->name('vote.store');
    Route::get('/vote/success',       [VoterCastedVoteController::class, 'success'])->name('vote.success');
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