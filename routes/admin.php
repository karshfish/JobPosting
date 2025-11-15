<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobModerationController;
use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;

Route::middleware(['auth','role:admin,super_admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('/jobs', [JobModerationController::class,'index'])->name('jobs.index');
        Route::get('/jobs/pending', [JobModerationController::class,'pending'])->name('jobs.pending');
        Route::get('/jobs/{job}', [JobModerationController::class,'show'])->name('jobs.show');
        Route::post('/jobs/{job}/approve', [JobModerationController::class,'approve'])->name('jobs.approve');
        Route::post('/jobs/{job}/reject', [JobModerationController::class,'reject'])->name('jobs.reject');

        Route::get('/applications', [ApplicationManagementController::class,'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationManagementController::class,'show'])->name('applications.show');

        Route::resource('categories', CategoryController::class);
        // Companies removed from admin
        Route::resource('users', UserManagementController::class)->only(['index','edit','update','destroy']);
    });
