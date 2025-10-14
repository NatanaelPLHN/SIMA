<?php

use App\Http\Controllers\AssetsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\CategoryGroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\SubAdminDashboardController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\StockOpnameDepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssetUsageController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/opname', function () {
    return view('opname.index');
});
Route::get('/show', function () {
    return view('opname.show');
});
Route::get('/op', function () {
    return view('opname_bidang.index');
});
Route::get('/do', function () {
    return view('opname_bidang.opname');
});

// Auth routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('categories/by-group', [CategoryController::class, 'getByGroup'])->name('categories.by-group')->middleware('auth'); // optional: biar tetap butuh login

// Route publik untuk verifikasi aset via QR Code
Route::get('verify/asset/{asset:kode}', [AssetsController::class, 'verifyAsset'])->name('asset.public.verify');
Route::get('/api/asset/{kode}', [StockOpnameDepartmentController::class, 'getAssetDetailsByCode'])->name('api.asset.details');

Route::post('verify-password', [StockOpnameDepartmentController::class, 'verifyPassword'])->name('verifyPassword');
Route::get('/api/departements/{institutionId}', [UserController::class, 'getDepartements'])->name('api.departements');
Route::get('/api/employees/{departmentId}', [UserController::class, 'getEmployees'])->name('api.employees');

//import & export
// Route::post('employees/import', [EmployeeController::class, 'import'])->name('employee.import');
// Route::get('employees/export/', [EmployeeController::class, 'export'])->name('employee.export');;

// untuk menyimpan progress opname bidang
// Route::post('/opname/detail/{detail}/update-item', [StockOpnameDepartmentController::class, 'updateItem'])->name('opname.detail.update_item');



// User routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('in', [AuthController::class, 'login']);
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::resource('profile', controller: ProfileController::class);
});

// SubAdmin routes
Route::middleware(['auth', 'role:subadmin'])->prefix('subadmin')->name('subadmin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [SubAdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('employee', controller: EmployeeController::class);
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employee.import');
    Route::post('employees/export', [EmployeeController::class, 'export'])->name('employee.export');
    Route::post('users/export/', [UserController::class, 'export'])->name('user.export');;
    Route::resource('user', controller: UserController::class);
    Route::resource('profile', controller: ProfileController::class);

    Route::resource('assets', controller: AssetsController::class);

    Route::resource('profile', controller: ProfileController::class);

    // Custom create forms untuk masing-masing tipe asset
    Route::get('assets/create/bergerak', [AssetsController::class, 'create_gerak'])->name('assets.create_gerak');
    Route::get('assets/create/tidak-bergerak', [AssetsController::class, 'create_tidak'])->name('assets.create_tidak_bergerak');
    Route::get('assets/create/habis', [AssetsController::class, 'create_habis'])->name('assets.create_habis');

    Route::resource('opname', controller: StockOpnameDepartmentController::class);
    Route::post('opname/{opname}/complete', [StockOpnameDepartmentController::class, 'complete'])->name('opname.complete');
    Route::post('opname/{session}/start', [StockOpnameDepartmentController::class, 'startOpname'])->name('opname.startOpname');


    // Autosave per-detail (AJAX partial update) — best practice: PATCH
    Route::patch('opname/details/{detail}', [StockOpnameDepartmentController::class, 'updateItem'])
        ->name('opname.details.update');

    // Definisikan route 'create' secara manual untuk menerima parameter opsional
    Route::get('asset-usage/create/{jenisAset?}', [AssetUsageController::class, 'create'])->name(
        'asset-usage.create'
    );

    // Daftarkan sisa resource route, kecuali 'create' yang sudah kita definisikan di atas
    Route::resource('asset-usage', AssetUsageController::class)->except(['create']);
    // Route::resource('asset-usage', AssetUsageController::class);

    // Route tambahan
    Route::put('asset-usage/{assetUsage}/return', [AssetUsageController::class, 'returnAsset'])
        ->name('asset-usage.return');

    Route::get('asset-usage/active', [AssetUsageController::class, 'active'])
        ->name('asset-usage.active');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('departement', controller: DepartementController::class);
    Route::resource('employee', controller: EmployeeController::class);
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employee.import');
    Route::post('employees/export', [EmployeeController::class, 'export'])->name('employee.export');
    Route::post('users/export/', [UserController::class, 'export'])->name('user.export');;
    Route::resource('user', controller: UserController::class);
    Route::resource('profile', controller: ProfileController::class);

    Route::resource('borrowing', controller: BorrowingController::class);
    Route::get('peminjaman', [AdminDashboardController::class, 'peminjaman'])->name('peminjaman');
    Route::get('peminjaman/pinjam', [AdminDashboardController::class, 'pinjam'])->name('pinjam');
    Route::get('bergerak', [AdminDashboardController::class, 'bergerak'])->name('bergerak');

    Route::resource('opname', controller: StockOpnameController::class);
    Route::post('opname/{opname}/start', [StockOpnameController::class, 'start'])->name('opname.start');
    Route::post('opname/{opname}/cancel', [StockOpnameController::class, 'cancel'])->name('opname.cancel');
});

// Superadmin routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('dashboard', [SuperAdminDashboardController::class, 'dashboard'])->name('dashboard');
    // Route::get('qr', [SuperAdminDashboardController::class, 'qr'])->name('qr');
    // Route::get('profil', [SuperAdminDashboardController::class, 'profil'])->name('profil');

    // routes institution (institusi)
    Route::resource('institution', controller: InstitutionController::class);
    Route::resource('user', controller: UserController::class);
    Route::resource('employee', controller: EmployeeController::class);
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employee.import');
    Route::post('employees/export/', [EmployeeController::class, 'export'])->name('employee.export');;
    Route::post('users/export/', [UserController::class, 'export'])->name('user.export');;
    Route::resource('profile', controller: ProfileController::class);

    // routes category-groups (grup kategori)
    Route::resource('category-groups', CategoryGroupController::class);
    // routes category (kategori)
    Route::get('categories/by-group', [CategoryController::class, 'getByGroup'])->name('categories.by-group');
    Route::resource('categories', CategoryController::class);
});
