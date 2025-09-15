<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;

class SuperadminDashboardController extends Controller
{
    public function index()
    {
        // Superadmin bisa lihat statistik semua
        $totalAssets = Asset::count();
        $rusak = Asset::where('status', 'rusak')->count();
        $hilang = Asset::where(column: 'status', 'hilang')->count();

        $totalUsers = User::count();
        $admins = User::where('role','admin')->count();
        $pegawai = User::where('role','pegawai')->count();

        return view('dashboards.superadmin', compact(
            'totalAssets','rusak','hilang','totalUsers','admins','pegawai'
        ));
    }
}
