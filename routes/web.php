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

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
Route::middleware(['auth'])->group(function () {
    Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');

    Route::get('/candidate/profile', [CandidateController::class, 'editProfile'])->name('candidate.profile');
    Route::post('/candidate/profile', [CandidateController::class, 'updateProfile'])->name('candidate.profile.update');

    // عرض جميع الوظائف + الفلترة
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

    // عرض تفاصيل وظيفة
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

    // تقديم على وظيفة
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');

});




require __DIR__.'/auth.php';
require __DIR__ . '/candidate.php';
