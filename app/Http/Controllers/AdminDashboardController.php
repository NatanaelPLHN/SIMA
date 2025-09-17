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
        // Admin bisa lihat ringkasan + manage aset
        // $totalAssets = Asset::count();
        // $tersedia = Asset::where('status', 'tersedia')->count();
        // $dipakai = Asset::where('status', 'dipakai')->count();

        return view('admin.assets.index');
    }

    // old
    // public function index()
    // {
    //     return view('admin.asset');
    //     // return view('admin.dashboard');
    // }

    public function bergerak()
    {
        return view('admin.Detail.bergerak');
    }
    public function tidak_bergerak()
    {
        return view('admin.Detail.tidak_bergerak');
    }
    public function habis()
    {
        return view('admin.Detail.habis');
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
