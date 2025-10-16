<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Departement;
use App\Models\Employee;
use App\Models\StockOpnameSession;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use Spatie\Activitylog\Models\Activity;

class AdminDashboardController extends Controller
{
    public function dashboard()
{
    $user = auth()->user();
    $institutionId = $user->employee->institution_id;

    // 🔹 Query dasar yang difilter berdasarkan instansi
    $departements = Departement::where('instansi_id', $institutionId);
    $employees = Employee::where('institution_id', $institutionId);
    $users = User::whereHas('employee', fn($q) => $q->where('institution_id', $institutionId));
    $assets = Asset::whereHas('departement', fn($q) => $q->where('instansi_id', $institutionId));
    $stockOpnameSessions = StockOpnameSession::whereHas('departement', fn($q) => $q->where('instansi_id', $institutionId));
    $activities = Activity::whereHas('causer.employee', fn($q) => $q->where('institution_id', $institutionId));

    return view('admin.dashboard', [
        'stats' => [
            'bidang' => $departements->count(),
            'pegawai' => $employees->count(),
            'akun_aktif' => $users->count(),
            'aset' => $assets->count(),
            'aset_bergerak' => $assets->clone()->where('jenis_aset', 'bergerak')->count(),
            'aset_tidak_bergerak' => $assets->clone()->where('jenis_aset', 'tidak_bergerak')->count(),
            'aset_habis_pakai' => $assets->clone()->where('jenis_aset', 'habis_pakai')->count(),
        ],

        'asetPerBidang' => DB::table('aset')
            ->join('departements', 'aset.department_id', '=', 'departements.id')
            ->where('departements.instansi_id', $institutionId) // 🔥 filter instansi
            ->select('departements.nama as nama_bidang', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('departements.id', 'departements.nama')
            ->get(),

        'upcomingSchedules' => $stockOpnameSessions->clone()
            ->with('departement')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->orderBy('tanggal_dijadwalkan')
            ->limit(5)
            ->get(),

        'stockStatus' => [
            'selesai' => $stockOpnameSessions->clone()->where('status', 'selesai')->count(),
            'berlangsung' => $stockOpnameSessions->clone()->whereIn('status',[ 'proses', 'dijadwalkan'])->count(),
            'belum' => $stockOpnameSessions->clone()->where('status', 'draft')->count(),
            'total' => $stockOpnameSessions->clone()->count(),
        ],

        'recentActivities' => $activities->clone()->latest()->limit(5)->get(),
        'activities' => $activities->clone()->latest()->paginate(10),
    ]);
}
    // public function dashboard()
    // {
    //     $institutionId = auth()->user()->employee->institution_id;

    //     $upcomingSchedules = StockOpnameSession::with('departement')
    //         ->whereHas('departement', function ($query) use ($institutionId) {
    //             $query->where('instansi_id', $institutionId);
    //         })
    //         ->whereNotIn('status', ['completed', 'cancelled'])
    //         ->orderBy('tanggal_dijadwalkan')
    //         ->limit(5)
    //         ->get();
    //     $totalAssets = Asset::count();
    //     $tersedia = Asset::where('status', 'tersedia')->count();
    //     $dipakai = Asset::where('status', 'dipakai')->count();
    //     // $activities = Activity::latest()->get(); // recent 20 logs
    //     $activities = Activity::latest()->paginate(10);
    //     return view('admin.dashboard', [
    //         'stats' => [
    //             'bidang' => Departement::count(),
    //             'pegawai' => Employee::count(),
    //             'akun_aktif' => User::count(),
    //             'aset' => Asset::count(),
    //             'aset_bergerak' => Asset::where('jenis_aset', 'bergerak')->count(),
    //             'aset_tidak_bergerak' => Asset::where('jenis_aset', 'tidak_bergerak')->count(),
    //             'aset_habis_pakai' => Asset::where('jenis_aset', 'habis_pakai')->count(),
    //         ],
    //         'asetPerBidang' => DB::table('aset')
    //             ->join('departements', 'aset.department_id', '=', 'departements.id')
    //             ->select('departements.nama as nama_bidang', DB::raw('COUNT(*) as jumlah'))
    //             ->groupBy('departements.id', 'departements.nama')
    //             ->get(),
    //         // ✅ Benar — sesuai dengan controller Anda
    //         'upcomingSchedules' => StockOpnameSession::with('departement')
    //             ->whereNotIn('status', ['completed', 'cancelled'])
    //             ->orderBy('tanggal_dijadwalkan')
    //             ->limit(5)
    //             ->get(),

    //         'stockStatus' => [
    //             'selesai' => StockOpnameSession::where('status', 'completed')->count(),
    //             'berlangsung' => StockOpnameSession::where('status', 'ongoing')->count(),
    //             'belum' => StockOpnameSession::whereIn('status', ['draft', 'dijadwalkan'])->count(),
    //             'total' => StockOpnameSession::count(),
    //         ],

    //         'recentActivities' => Activity::latest()->limit(5)->get(),
    //         'activities' => Activity::latest()->paginate(10), // jika juga dipakai di tabel lengkap
    //     // return view('admin.dashboard', compact('totalAssets', 'tersedia', 'dipakai', 'activities'));
            
    //     ]);
    //     // return view('admin.dashboard', compact('totalAssets', 'tersedia', 'dipakai', 'activities'));

    // }
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
