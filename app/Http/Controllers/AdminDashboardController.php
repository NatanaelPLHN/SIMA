<?php

namespace App\Http\Controllers;

use App\Models\Asset;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $totalAssets = Asset::count();
        $tersedia = Asset::where('status', 'tersedia')->count();
        $dipakai = Asset::where('status', 'dipakai')->count();

        return view('admin.dashboard', compact('totalAssets', 'tersedia', 'dipakai'));
    }
    public function asset()
    {
        return view('admin.assets.index');
    }

    public function peminjaman()
    {
        return view('admin.peminjaman');
    }
    public function pinjam()
    {
        return view('admin.Forms.pinjam');
    }
    public function profil()
    {
        return view('layouts.profil');
    }
}
