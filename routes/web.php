<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PartylistController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Voter\CastedVoteController;
use App\Http\Controllers\Voter\FeedbackController;
use App\Http\Controllers\Voter\VoterDashboardController;
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
    Route::resource('candidates', CandidateController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('partylists', PartylistController::class);
    Route::resource('organizations', OrganizationController::class);
    Route::resource('colleges', CollegeController::class);
});

// Voter routes
Route::middleware(['auth', 'voter'])->group(function () {
    Route::get('/voter/dashboard', [VoterDashboardController::class, 'index'])->name('voter.dashboard');
    Route::resource('votes', CastedVoteController::class);
    Route::resource('feedback', FeedbackController::class);
});

require __DIR__.'/auth.php';
