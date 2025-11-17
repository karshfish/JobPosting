
<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;

// Route::get('/', function () {
//     return view('welcome');
// });
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/jobs', [HomeController::class, 'jobs'])->name('jobs');

Route::get('/jobs/{job}', [HomeController::class, 'show'])->name('jobs.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Session test routes for debugging
Route::get('/session-test/set', function (\Illuminate\Http\Request $request) {
    $request->session()->put('test_key', 'test_value');
    return 'Session value set. <a href="/session-test/get">Check value</a>';
});
Route::get('/session-test/get', function (\Illuminate\Http\Request $request) {
    $val = $request->session()->get('test_key', 'not set');
    return 'Session value is: ' . $val;
});

require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/candidate.php';
require __DIR__ . '/employer.php';
