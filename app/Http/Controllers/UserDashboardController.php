<?php

namespace App\Http\Controllers;

use App\Models\Asset;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Pegawai hanya bisa melihat daftar aset
        $assets = Asset::paginate(10);

        return view('user.dashboard', compact('assets'));
    }
}
