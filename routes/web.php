<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCandidateController;
use App\Http\Controllers\Admin\AdminCollegeController;
use App\Http\Controllers\Admin\AdminOrganizationController;
use App\Http\Controllers\Admin\AdminPartylistController;
use App\Http\Controllers\Admin\AdminPositionController;
use App\Http\Controllers\Voter\CastedVoteController;
use App\Http\Controllers\Voter\FeedbackController;
use App\Http\Controllers\Voter\VoterDashboardController;
use App\Http\Controllers\Admin\AdminVoterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('candidates', AdminCandidateController::class);
    Route::resource('positions', AdminPositionController::class);
    Route::resource('partylists', AdminPartylistController::class);
    Route::resource('organizations', AdminOrganizationController::class);
    Route::resource('colleges', AdminCollegeController::class);
    Route::get('/admin/votes/results', [AdminCastedVoteController::class, 'results'])->name('admin.votes.results');
    Route::resource('admin/votes', AdminCastedVoteController::class)->names('admin.votes');
    Route::patch('/admin/voters/{voter}/status', [AdminVoterController::class, 'toggleStatus'])->name('admin.voters.toggle-status');
    Route::resource('admin/voters', AdminVoterController::class)->names('admin.voters');
});

// Voter routes
Route::middleware(['auth', 'voter'])->group(function () {
    Route::get('/voter/dashboard', [VoterDashboardController::class, 'index'])->name('voter.dashboard');
    Route::resource('votes', CastedVoteController::class);
    Route::resource('feedback', FeedbackController::class);
});

require __DIR__.'/auth.php';
