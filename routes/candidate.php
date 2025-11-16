<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\Employer\JobPostController;
use App\Http\Controllers\Candidate\JobController as CandidateJobController;

Route::middleware('auth', 'role:candidate')->group(function () {
    Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');
    Route::get('/candidate/profile', [CandidateController::class, 'editProfile'])->name('candidate.profile');
    Route::put('/candidate/profile', [CandidateController::class, 'updateProfile'])->name('candidate.updateProfile');


    Route::get('/candidate/jobs', [CandidateController::class, 'jobPosts'])
        ->name('candidate.jobs');

    

    Route::get('/candidate/job/{job}', [CandidateController::class, 'showJob'])
        ->name('candidate.show-job');

    Route::get('/candidate/jobs/{job}/apply', [CandidateController::class, 'showApplyForm'])->name('candidate.jobs.apply');
    Route::post('/candidate/jobs/{job}/apply', [CandidateController::class, 'submitApplication'])->name('candidate.jobs.submit');
    Route::get('/candidate/jobs/{job}', [CandidateController::class, 'showJob'])->name('candidate.jobs.show');

    Route::get('/candidate/applications', [CandidateController::class, 'applications'])->name('candidate.applications');
    Route::get('/candidate/applications/{application}/edit', [CandidateController::class, 'editApplication'])->name('candidate.applications.edit');
    Route::put('/candidate/applications/{application}', [CandidateController::class, 'updateApplication'])->name('candidate.applications.update');
    Route::delete('/candidate/applications/{application}', [CandidateController::class, 'deleteApplication'])->name('candidate.applications.delete');

    Route::get('/candidate/jobs/{job}/linkedin-apply', [CandidateController::class, 'applyViaLinkedIn'])
        ->name('candidate.linkedin.apply');
    Route::get('/auth/linkedin', [LinkedInController::class, 'redirect'])->name('linkedin.redirect');
    Route::get('/auth/linkedin/callback', [LinkedInController::class, 'callback'])->name('linkedin.callback');
});
