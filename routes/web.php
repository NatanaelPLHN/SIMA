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
Route::middleware(['auth', 'role:user']) ->prefix('user')->name('user.')->group(function () {
    Route::get('/in', [AuthController::class, 'login']);
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [UserDashboardController::class, 'profil'])->name('profil');
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
Route::middleware(['auth', 'role:superadmin']) ->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/qr', [SuperAdminDashboardController::class, 'qr'])->name('qr');
    // instansi
    Route::get('/superadmin/instansi', [SuperAdminDashboardController::class, 'instansi'])->name('instansi');
    Route::get('/profil', [SuperAdminDashboardController::class, 'profil'])->name('profil');
    Route::get('/superadmin/instansi/create', [SuperAdminDashboardController::class, 'create_instansi'])->name('superadmin.create_instansi');
    Route::get('/superadmin/instansi/edit', [SuperAdminDashboardController::class, 'edit_instansi'])->name('superadmin.edit_instansi');

// bidang
    Route::get('/superadmin/bidang', [SuperAdminDashboardController::class, 'bidang'])->name('superadmin.bidang');
    Route::get('/superadmin/bidang/create', [SuperAdminDashboardController::class, 'create_bidang'])->name('superadmin.create_bidang');
    Route::get('/superadmin/bidang/edit', [SuperAdminDashboardController::class, 'edit_bidang'])->name('superadmin.edit_bidang');
});
