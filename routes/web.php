<?php

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
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/asset', [AdminDashboardController::class, 'asset'])->name('admin.asset');
    Route::get('/admin/bergerak', [AdminDashboardController::class, 'create_gerak'])->name('admin.create_gerak');
    Route::get('/admin/tidak_bergerak', [AdminDashboardController::class, 'create_tidak'])->name('admin.create_tidak_bergerak');
    Route::get('/admin/habis', [AdminDashboardController::class, 'create_habis'])->name('admin.create_habis');
    Route::get('/admin/asset/bergerak/1', [AdminDashboardController::class, 'bergerak'])->name('admin.bergerak');
    Route::get('/admin/asset/tidak_bergerak/1', [AdminDashboardController::class, 'tidak_bergerak'])->name('admin.tidak_bergerak');
    Route::get('/admin/asset/habis/1', [AdminDashboardController::class, 'habis'])->name('admin.habis');
    Route::get('/admin/peminjaman', [AdminDashboardController::class, 'peminjaman'])->name('admin.peminjaman');
    Route::get('/admin/peminjaman/pinjam', [AdminDashboardController::class, 'pinjam'])->name('admin.pinjam');
    Route::get('/admin/profil', [AdminDashboardController::class, 'profil'])->name('profil');
});

// Superadmin dashboard routes
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin/qr', [SuperAdminDashboardController::class, 'qr'])->name('superadmin.qr');
});
