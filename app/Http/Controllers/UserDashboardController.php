<?php

namespace App\Http\Controllers;

use App\Models\Asset;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        // Pegawai hanya bisa melihat daftar aset
        $assets = Asset::paginate(10);
        $stats = [
            'aset_bergerak'     => Asset::where('jenis_aset', 'bergerak')->count(),
            'aset_tetap'        => Asset::where('jenis_aset', 'tidak_bergerak')->count(),
            'aset_habis_pakai'  => Asset::where('jenis_aset', 'habis_pakai')->count(),
        ];
        return view('user.dashboard', compact('stats'));
    }
    public function profil()
    {
        return view('layouts.profil');
    }
}
