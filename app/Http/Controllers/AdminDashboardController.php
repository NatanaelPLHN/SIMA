<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Spatie\Activitylog\Models\Activity;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $totalAssets = Asset::count();
        $tersedia = Asset::where('status', 'tersedia')->count();
        $dipakai = Asset::where('status', 'dipakai')->count();
        // $activities = Activity::latest()->get(); // recent 20 logs
        $activities = Activity::latest()->paginate(10);

        return view('admin.dashboard', compact('totalAssets', 'tersedia', 'dipakai', 'activities'));

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
