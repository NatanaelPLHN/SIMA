<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/ayam', function () {
    return view('ayam');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/logogout', [AuthController::class, 'logout'])->name('logout');

// User dashboard routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/in', [AuthController::class, 'login']);
Route::post('/luser/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Admin dashboard routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});