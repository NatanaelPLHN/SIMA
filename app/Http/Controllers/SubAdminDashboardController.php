<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

use App\Models\Asset;

class SubAdminDashboardController extends Controller
{
    public function dashboard()
    {
        // $totalAssets = Asset::count();
        // $tersedia = Asset::where('status', 'tersedia')->count();
        // $dipakai = Asset::where('status', 'dipakai')->count();
        // $activities = Activity::latest()->paginate(10);
        $user = auth()->user();
        $departmentId = $user->employee->department_id;

        // 2. Filter aset berdasarkan departemen
        $assetsInDepartment = Asset::where('department_id', $departmentId);

        $totalAssets = $assetsInDepartment->count();
        $tersedia = $assetsInDepartment->clone()->where('status', 'tersedia')->count();
        $dipakai = $assetsInDepartment->clone()->where('status', 'dipakai')->count();

        // 3. Filter log aktivitas berdasarkan aset di departemen tersebut
        $activities = Activity::where('subject_type', Asset::class)
            ->whereHasMorph('subject', [Asset::class], function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->latest()
            ->paginate(10);
        return view('subadmin.dashboard', compact('totalAssets', 'tersedia', 'dipakai', 'activities'));
    }
    public function asset()
    {
        return view('subadmin.admin.assets.index');
    }

    public function peminjaman()
    {
        return view('subadmin.admin.peminjaman');
    }
    public function pinjam()
    {
        return view('subadmin.admin.Forms.pinjam');
    }
    public function profil()
    {
        return view('layouts.profil');
    }
}
