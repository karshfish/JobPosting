<?php

use App\Http\Controllers\Employer\EmployerDashboardController;
use App\Http\Controllers\Employer\JobPostController;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobController;



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



Route::middleware(['auth'])->group(function () {


    // Candidate Dashboard
    Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])
        ->name('candidate.dashboard');

    // Candidate Profile (Edit & Update)
    Route::get('/candidate/profile', [CandidateController::class, 'editProfile'])
        ->name('candidate.profile');
    Route::put('/candidate/profile', [CandidateController::class, 'updateProfile'])
        ->name('candidate.updateProfile');
    Route::get('/candidate/edit-profile', [CandidateController::class, 'editProfile'])
        ->name('candidate.edit-profile');

    // Candidate Applications
    Route::get('/candidate/applications', [CandidateController::class, 'applications'])
        ->name('candidate.applications');
    // Show apply form for a job
    Route::get('jobs/{job}/apply', [CandidateController::class, 'showApplyForm'])->name('candidate.jobs.apply');

    // Submit application
    Route::post('jobs/{job}/apply', [CandidateController::class, 'submitApplication'])->name('candidate.jobs.submit');

});

require __DIR__ . '/candidate.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/candidate.php';


Route::get('/employer', function () {
    return redirect()->route('employer.dashboard');
});
// Route::middleware(['auth', 'role:employer'])->group(function () {
Route::middleware('auth')->group(function () {
    Route::get('/employer/dashboard', [EmployerDashboardController::class, 'index'])->name('employer.dashboard');
    Route::resource('jobs', JobPostController::class);
    Route::get('/applications', [CandidateController::class, 'index']);
    Route::get('/job-listings', [JobListingController::class, 'index'])->name('employer.jobListings');
    Route::post('/jobs/{job}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/employer/analysis', [App\Http\Controllers\Employer\AnalysisController::class, 'index'])
    ->name('employer.analysis')
    ->middleware('auth');


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
