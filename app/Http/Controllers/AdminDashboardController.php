<?php

namespace App\Http\Controllers;

use App\Models\Asset;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Admin bisa lihat ringkasan + manage aset
        $totalAssets = Asset::count();
        $tersedia = Asset::where('status', 'tersedia')->count();
        $dipakai = Asset::where('status', 'dipakai')->count();

        return view('dashboards.admin', compact('totalAssets', 'tersedia', 'dipakai'));
    }

    // old
    // public function index()
    // {
    //     return view('admin.asset');
    //     // return view('admin.dashboard');
    // }

    public function create_gerak()
    {
        // return view('admin.dashboard');
        return view('admin.create-gerak');
    }
}
