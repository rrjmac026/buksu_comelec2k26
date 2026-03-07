<?php

use App\Http\Controllers\ProfileController;
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
    Route::resource('candidates', CandidateController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('partylists', PartylistController::class);
    Route::resource('organizations', OrganizationController::class);
    Route::resource('colleges', CollegeController::class);
});

// Voter routes
Route::middleware(['auth', 'voter'])->group(function () {
    Route::resource('votes', CastedVoteController::class);
    Route::resource('feedback', FeedbackController::class);
});

require __DIR__.'/auth.php';
