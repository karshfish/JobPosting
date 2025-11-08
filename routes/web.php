<?php

use App\Http\Controllers\Employer\EmployerDashboardController;
use App\Http\Controllers\Employer\JobPostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobListingController;
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

Route::get('/employer', function () {
    return redirect()->route('employer.dashboard');
});
// Route::middleware(['auth', 'role:employer'])->group(function () {
Route::middleware('auth')->group(function () {
    Route::get('/employer/dashboard', [EmployerDashboardController::class, 'index'])->name('employer.dashboard');
    Route::resource('jobs', JobPostController::class);
    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::get('/job-listings', [JobListingController::class, 'index'])->name('employer.jobListings');
});

Route::get('/employer/analysis', [App\Http\Controllers\Employer\AnalysisController::class, 'index'])
    ->name('employer.analysis')
    ->middleware('auth');


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

