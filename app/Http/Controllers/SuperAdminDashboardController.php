<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;

class SuperadminDashboardController extends Controller
{
    public function dashboard()
    {
        // Superadmin bisa lihat statistik semua
        $totalAssets = Asset::count();
        $rusak = Asset::where('status', 'rusak')->count();
        $hilang = Asset::where('status', 'hilang')->count();
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $pegawai = User::where('role', 'pegawai')->count();

        return view('superadmin.dashboard', compact(
            'totalAssets',
            'rusak',
            'hilang',
            'totalUsers',
            'admins',
            'pegawai'
        ));
    }
    public function qr()
    {
        return view('superadmin.qr');
    }
    public function instansi()
    {
        return view('superadmin.instansi');
    }
    public function profil()
    {
        return view('layouts.profil');
    }
}
