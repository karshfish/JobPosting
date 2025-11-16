<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Employer\AnalysisController;
use App\Http\Controllers\Employer\ApplicationsController;
use App\Http\Controllers\Employer\EmployerDashboardController;
use App\Http\Controllers\Employer\JobPostController;
use Illuminate\Support\Facades\Route;

Route::get('/employer', function () {
    return redirect()->route('employer.dashboard');
});

Route::middleware('auth')->group(function(){
    Route::post('/jobs/{job}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::middleware('auth', 'role:employer')->prefix('employer')->group(function () {
    Route::resource('jobs', JobPostController::class);
    Route::get('/employer/dashboard', [EmployerDashboardController::class, 'index'])->name('employer.dashboard');
    Route::get('/employer/analysis', [AnalysisController::class, 'index'])
        ->name('employer.analysis');
    Route::resource('employer/applications', ApplicationsController::class)
        ->names('Applications');
});
