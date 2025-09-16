<?php

use App\Http\Controllers\AssetsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/profil', function () {
//     return view('profil');
// });

// Route::get('/create', function () {
//     return view('form');
// });

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']); //
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User dashboard routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/in', [AuthController::class, 'login']);
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Admin dashboard routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Assets (resource route)
    Route::resource('assets', AssetsController::class);

    // Custom create forms for each jenis_aset (optional — if you still want them separated)
    Route::get('assets/create/bergerak', [AssetsController::class, 'create_gerak'])->name('assets.create_gerak');
    Route::get('assets/create/tidak-bergerak', [AssetsController::class, 'create_tidak'])->name('assets.create_tidak_bergerak');
    Route::get('assets/create/habis', [AssetsController::class, 'create_habis'])->name('assets.create_habis');

    // Other pages from AdminDashboardController
    Route::get('/asset/bergerak/{id}', [AdminDashboardController::class, 'bergerak'])->name('asset.bergerak');
    Route::get('/asset/tidak-bergerak/{id}', [AdminDashboardController::class, 'tidak_bergerak'])->name('asset.tidak_bergerak');
    Route::get('/asset/habis/{id}', [AdminDashboardController::class, 'habis'])->name('asset.habis');

    Route::get('/peminjaman', [AdminDashboardController::class, 'peminjaman'])->name('peminjaman');
    Route::get('/peminjaman/pinjam', [AdminDashboardController::class, 'pinjam'])->name('pinjam');
    Route::get('/profil', [AdminDashboardController::class, 'profil'])->name('profil');
});


// Superadmin dashboard routes
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin/qr', [SuperAdminDashboardController::class, 'qr'])->name('superadmin.qr');
    Route::get('/superadmin/instansi', [SuperAdminDashboardController::class, 'instansi'])->name('superadmin.instansi');
});
