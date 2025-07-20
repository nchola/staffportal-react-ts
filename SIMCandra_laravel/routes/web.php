<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\RekrutmenController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RewardPunishmentController;


// Redirect root to login page initially
Route::get('/', function () {
    // If user is already authenticated, redirect to dashboard
    if (Auth::check()) {
        // Menggunakan nama rute 'dashboard' yang sudah ada
        return redirect()->intended(route('dashboard'));
    }
    // Menggunakan nama rute 'login' yang sudah ada
    return redirect()->route('login');
});

// Dashboard route - protected by 'auth' middleware
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Handle login attempt
Route::post('/login', [LoginController::class, 'login']);
// Logout route
Route::post('/logout', function (Request $request) { // Define logout route closure directly or point to LoginController method
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // Redirect to root/login page after logout
})->name('logout');


// Resource route for managing employees, protected by 'auth' middleware
Route::resource('pegawai', PegawaiController::class)->middleware('auth');

// Resource route for managing absences, protected by 'auth' middleware
Route::resource('absensi', AbsensiController::class)->middleware('auth');

// Resource route for managing cuti, protected by 'auth' middleware
Route::resource('cuti', CutiController::class)->middleware('auth');
Route::post('cuti/{cuti}/verify', [CutiController::class, 'verify'])->name('cuti.verify')->middleware('auth');

// Resource route for managing lamaran, protected by 'auth' middleware
Route::resource('lamaran', LamaranController::class)->middleware('auth');

// Resource route for managing rekrutmen, protected by 'auth' middleware
Route::resource('rekrutmen', RekrutmenController::class)->middleware('auth');

// Resource route for managing mutasi, protected by 'auth' middleware
Route::resource('mutasi', \App\Http\Controllers\MutasiController::class)->middleware('auth');
Route::post('mutasi/{id}/verify', [\App\Http\Controllers\MutasiController::class, 'verify'])->name('mutasi.verify')->middleware('auth');
Route::get('mutasi/print', [\App\Http\Controllers\MutasiController::class, 'print'])->name('mutasi.print')->middleware('auth');

// Resource route for managing departemen, protected by 'auth' middleware
Route::resource('departemen', \App\Http\Controllers\DepartemenController::class)->middleware('auth');

// Resource route for managing jabatan, protected by 'auth' middleware
Route::resource('jabatan', \App\Http\Controllers\JabatanController::class)->middleware('auth');

Route::get('pegawai/{id}/info', [\App\Http\Controllers\PegawaiController::class, 'info'])->name('pegawai.info')->middleware('auth');

Route::get('departemen/{id}/jabatans', [\App\Http\Controllers\DepartemenController::class, 'jabatans'])->name('departemen.jabatans')->middleware('auth');

// Resource route for managing user, protected by 'auth' middleware
Route::resource('user', \App\Http\Controllers\UserController::class)->middleware('auth');

// Register routes for calon karyawan
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Resource route for managing rewardpunishment, protected by 'auth' middleware
Route::resource('rewardpunishment', RewardPunishmentController::class)->middleware('auth');
Route::put('rewardpunishment/{id}/status', [RewardPunishmentController::class, 'status'])->name('rewardpunishment.status')->middleware('auth');
Route::post('rewardpunishment/{id}/verify', [RewardPunishmentController::class, 'verify'])->name('rewardpunishment.verify')->middleware('auth');

// Resource route for managing resign, protected by 'auth' middleware
Route::resource('resign', \App\Http\Controllers\ResignController::class)->middleware('auth');
Route::post('resign/{id}/verify', [\App\Http\Controllers\ResignController::class, 'verify'])->name('resign.verify')->middleware('auth');

// Resource route for managing PHK, protected by 'auth' middleware
Route::middleware(['auth'])->group(function () {
    Route::resource('phk', 'App\\Http\\Controllers\\PhkController');
    Route::post('phk/{id}/verify', [App\Http\Controllers\PhkController::class, 'verify'])->name('phk.verify');
});

