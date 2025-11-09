<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;


Route::middleware(['auth'])->group(function () {
    Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');

    Route::get('/candidate/profile', [CandidateController::class, 'editProfile'])->name('candidate.profile');
    Route::post('/candidate/profile', [CandidateController::class, 'updateProfile'])->name('candidate.profile.update');
});
