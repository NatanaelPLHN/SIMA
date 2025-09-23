<?php

use App\Http\Controllers\AssetsController;
use App\Http\Controllers\EmployeeController;
// use App\Http\Controllers\KaryawanController;
// use App\Http\Controllers\InstansiController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\CategoryGroupController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/detail', function () {
//     return redirect('');
// });

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

// Tambahkan route untuk category groups


// User dashboard routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/in', [AuthController::class, 'login']);
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [UserDashboardController::class, 'profil'])->name('profil');
});

// Admin dashboard routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Assets (resource route)
    Route::resource('assets', controller: AssetsController::class);

    // Custom create forms for each jenis_aset (optional — if you still want them separated)
    Route::get('assets/create/bergerak', [AssetsController::class, 'create_gerak'])->name('assets.create_gerak');
    Route::get('assets/create/tidak-bergerak', [AssetsController::class, 'create_tidak'])->name('assets.create_tidak_bergerak');
    Route::get('assets/create/habis', [AssetsController::class, 'create_habis'])->name('assets.create_habis');

    // Other pages from AdminDashboardController
    // Route::get('assets/bergerak/{id}', [AdminDashboardController::class, 'bergerak'])->name('assets.bergerak');
    // Route::get('assets/tidak-bergerak/{id}', [AdminDashboardController::class, 'tidak_bergerak'])->name('assets.tidak_bergerak');
    // Route::get('assets/habis/{id}', [AdminDashboardController::class, 'habis'])->name('assets.habis');
    // Route::get('assets/{id}', [AssetsController::class, 'showAsset'])->name('assets.show');

    Route::get('peminjaman', [AdminDashboardController::class, 'peminjaman'])->name('peminjaman');
    Route::get('peminjaman/pinjam', [AdminDashboardController::class, 'pinjam'])->name('pinjam');
    Route::get('profil', [AdminDashboardController::class, 'profil'])->name('profil');
    Route::get('/bergerak', [AdminDashboardController::class, 'bergerak'])->name('bergerak');
});


// Superadmin dashboard routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/qr', [SuperAdminDashboardController::class, 'qr'])->name('qr');
    // instansi
    // Route::get('/instansi', [SuperAdminDashboardController::class, 'instansi'])->name('instansi');
    Route::get('/profil', [SuperAdminDashboardController::class, 'profil'])->name('profil');
    // Route::get('/instansi/create', [SuperAdminDashboardController::class, 'create_instansi'])->name('create_instansi');
    // Route::get('/instansi/edit', [SuperAdminDashboardController::class, 'edit_instansi'])->name('edit_instansi');

    // bidang
    // Route::get('/bidang', [SuperAdminDashboardController::class, 'bidang'])->name('bidang');
    // Route::get('/bidang/create', [SuperAdminDashboardController::class, 'create_bidang'])->name('create_bidang');
    // Route::get('/bidang/edit', [SuperAdminDashboardController::class, 'edit_bidang'])->name('edit_bidang');

    Route::resource('assets', controller: AssetsController::class);
    // Tambahkan route untuk karyawan
    // Route::resource('karyawan', controller: KaryawanController::class);
    Route::resource('employees', controller: EmployeeController::class);
    // Tambahkan route untuk instansi
    // Route::resource('instansi', controller: InstansiController::class);
    Route::resource('institution', controller: InstitutionController::class);
    // Tambahkan route untuk grup kategori
    Route::resource('category-groups', CategoryGroupController::class);
    // Tambahkan route untuk categories
    Route::resource('categories', CategoryController::class);
    // Tambahkan route untuk bidang
    Route::resource('bidang', controller: BidangController::class);
});
