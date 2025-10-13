<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

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

        $activities = Activity::latest()->get(); // recent 20 logs

        return view('superadmin.dashboard', compact('totalAssets', 'rusak', 'hilang', 'totalUsers', 'admins', 'pegawai', 'activities',));
    }

    // public function instansi()
    // {
    //     return view('superadmin.instansi');
    // }
    public function profil()
    {
        return view('layouts.profil');
    }
    // public function create_instansi()
    // {
    //     return view('superadmin.Forms.create_instansi');
    // }
    // public function edit_instansi()
    // {
    //     return view('superadmin.Forms.edit_instansi');
    // }
    // public function bidang()
    // {
    //     return view('superadmin.bidang');
    // }
    // public function create_bidang()
    // {
    //     return view('superadmin.Forms.create_bidang');
    // }
    // public function edit_bidang()
    // {
    //     return view('superadmin.Forms.edit_bidang');
    // }
}
