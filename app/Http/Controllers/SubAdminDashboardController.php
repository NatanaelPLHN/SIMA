<?php

namespace App\Http\Controllers;

use App\Models\Asset;

class SubAdminDashboardController extends Controller
{
    public function dashboard()
    {
        $totalAssets = Asset::count();
        $tersedia = Asset::where('status', 'tersedia')->count();
        $dipakai = Asset::where('status', 'dipakai')->count();

        return view('subadmin.dashboard', compact('totalAssets', 'tersedia', 'dipakai'));
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
