<?php

namespace App\Http\Controllers;
// use App\Models\Institution;
use App\Models\Employee;
use App\Models\Institution;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class SuperadminDashboardController extends Controller
{
    public function dashboard()
    {
        $institutionCount = Institution::count();
        $totalCategories = Category::count();          // Total Kategori
        $totalCategoryGroups = CategoryGroup::count(); // Total Grup Kategori
        $totalUsers = User::count();
        $totalEmployees = Employee::count();
        // Opsional: Tetap ambil aktivitas jika ingin ditampilkan nanti
        $recentActivities = Activity::with('causer')
            ->latest()
            ->take(6)
            ->get();

        return view('superadmin.dashboard', compact(
            'institutionCount',
            'totalCategories',
            'totalCategoryGroups',
            'totalUsers',
            'totalEmployees',
            'recentActivities'
        ));
    }

    public function profil()
    {
        return view('layouts.profil');
    }
}