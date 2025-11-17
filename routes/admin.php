<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobModerationController;
use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('/jobs', [JobModerationController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/pending', [JobModerationController::class, 'pending'])->name('jobs.pending');
        Route::get('/jobs/published', [JobModerationController::class, 'published'])->name('jobs.published');
        Route::get('/jobs/trashed', [JobModerationController::class, 'trashed'])->name('jobs.trashed');
        Route::get('/jobs/{job}', [JobModerationController::class, 'show'])->name('jobs.show');
        Route::post('/jobs/{job}/approve', [JobModerationController::class, 'approve'])->name('jobs.approve');
        Route::post('/jobs/{job}/reject', [JobModerationController::class, 'reject'])->name('jobs.reject');
        Route::patch('/jobs/{job}/republish', [JobModerationController::class, 'republish'])->name('jobs.republish');
        Route::delete('/jobs/{job}', [JobModerationController::class, 'destroy'])->name('jobs.destroy');
        Route::patch('/jobs/{job}/restore', [JobModerationController::class, 'restore'])->name('jobs.restore');
        Route::delete('/jobs/{job}/force-delete', [JobModerationController::class, 'forceDelete'])->name('jobs.force-delete');

        Route::get('/applications', [ApplicationManagementController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationManagementController::class, 'show'])->name('applications.show');

        Route::resource('categories', CategoryController::class);
        // Companies removed from admin
        Route::patch('/users/{user}/restore', [UserManagementController::class, 'restore'])->name('users.restore');
        Route::resource('users', UserManagementController::class)->only(['index', 'edit', 'update', 'destroy']);
    });
