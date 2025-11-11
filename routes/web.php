<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;




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
    Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');

    Route::get('/candidate/profile', [CandidateController::class, 'editProfile'])->name('candidate.profile');
    Route::post('/candidate/profile', [CandidateController::class, 'updateProfile'])->name('candidate.profile.update');


});




require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/candidate.php';
require __DIR__ . '/employer.php';
