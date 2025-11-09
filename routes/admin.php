<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobModerationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserManagementController;

Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('/jobs', [JobModerationController::class,'index'])->name('jobs.index');
        Route::get('/jobs/pending', [JobModerationController::class,'pending'])->name('jobs.pending');
        Route::get('/jobs/{job}', [JobModerationController::class,'show'])->name('jobs.show');
        Route::post('/jobs/{job}/approve', [JobModerationController::class,'approve'])->name('jobs.approve');
        Route::post('/jobs/{job}/reject', [JobModerationController::class,'reject'])->name('jobs.reject');

        Route::resource('categories', CategoryController::class);
        Route::resource('companies', CompanyController::class)->except(['show']);
        Route::resource('users', UserManagementController::class)->only(['index','edit','update']);
    });
