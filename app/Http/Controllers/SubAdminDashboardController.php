<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Departement;
use App\Models\Employee;
use App\Models\StockOpnameSession;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use Spatie\Activitylog\Models\Activity;

class SubAdminDashboardController extends Controller
{

    public function dashboard()
    {
        $user = auth()->user();
        $departmentId = $user->employee->department_id;

        // Jika user tidak punya department_id, tampilkan halaman kosong atau error
        if (!$departmentId) {
            // Anda bisa memilih untuk menampilkan view kosong atau redirect dengan pesan error
            return view('subadmin.dashboard_empty'); // Contoh view kosong
        }

        // --- Query Dasar ---
        $assets = Asset::where('department_id', $departmentId);
        $employees = Employee::where('department_id', $departmentId);
        $users = User::whereHas('employee', fn($q) => $q->where('department_id', $departmentId));
        $stockOpnameSessions = StockOpnameSession::where('department_id', $departmentId);

        $activities = Activity::where('subject_type', Asset::class)
            ->whereHasMorph('subject', [Asset::class], function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });

        // --- Data untuk View ---
        return view('subadmin.dashboard', [
            'stats' => [
                'pegawai' => $employees->count(),
                'akun_aktif' => $users->count(),
                'aset' => $assets->count(),
                'aset_bergerak' => $assets->clone()->where('jenis_aset', 'bergerak')->count(),
                'aset_tidak_bergerak' => $assets->clone()->where('jenis_aset', 'tidak_bergerak')->count(),
                'aset_habis_pakai' => $assets->clone()->where('jenis_aset', 'habis_pakai')->count(),
            ],

            // Mengganti 'asetPerBidang' dengan 'asetPerStatus'
            'asetPerStatus' => DB::table('aset')
                ->where('department_id', $departmentId)
                ->select('status', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('status')
                ->pluck('jumlah', 'status'), // Hasilnya: ['tersedia' => 10, 'dipakai' => 5]

            'upcomingSchedules' => $stockOpnameSessions->clone()
                ->with('departement') // departement di sini hanya untuk nama, karena ID sudah pasti sama
                ->whereIn('status', ['dijadwalkan', 'proses'])
                ->orderBy('tanggal_dijadwalkan')
                ->limit(5)
                ->get(),

            'stockStatus' => [
                'selesai' => $stockOpnameSessions->clone()->where('status', 'selesai')->count(),
                'berlangsung' => $stockOpnameSessions->clone()->where('status', 'proses')->count(),
                'belum' => $stockOpnameSessions->clone()->where('status', 'dijadwalkan')->count(),
                'total' => $stockOpnameSessions->clone()->count(),
            ],

            'recentActivities' => $activities->clone()->latest()->limit(5)->get(),
            'activities' => $activities->clone()->latest()->paginate(10),
        ]);
    }

    // public function dashboard()
    // {
    //     $user = auth()->user();
    //     $departmentId = $user->employee->department_id;
    //     $institutionId = $user->employee->institution_id;

    //     // 🔹 Query dasar yang difilter berdasarkan instansi
    //     // $departements = Departement::where('id', $institutionId);
    //     $employees = Employee::where('department_id', $departmentId);
    //     $users = User::whereHas('employee', fn($q) => $q->where('department_id', $departmentId));
    //     $assets = Asset::whereHas('departement', fn($q) => $q->where('department_id', $departmentId));
    //     $stockOpnameSessions = StockOpnameSession::whereHas('departement', fn($q) => $q->where('id', $departmentId));

    //     // $activities = Activity::whereHas('causer.employee', fn($q) => $q->where('institution_id', $institutionId));
    //     $activities = Activity::where('subject_type', Asset::class)
    //         ->whereHasMorph('subject', [Asset::class], function ($query) use ($departmentId) {
    //             $query->whereHas('departement', function ($q) use ($departmentId) {
    //                 $q->where('id', $departmentId);
    //             });
    //         });
    //     return view('admin.dashboard', [
    //         'stats' => [
    //             // 'bidang' => $departements->count(),
    //             'pegawai' => $employees->count(),
    //             'akun_aktif' => $users->count(),
    //             'aset' => $assets->count(),
    //             'aset_bergerak' => $assets->clone()->where('jenis_aset', 'bergerak')->count(),
    //             'aset_tidak_bergerak' => $assets->clone()->where('jenis_aset', 'tidak_bergerak')->count(),
    //             'aset_habis_pakai' => $assets->clone()->where('jenis_aset', 'habis_pakai')->count(),
    //         ],

    //         'asetPerBidang' => DB::table('aset')
    //             ->join('departements', 'aset.department_id', '=', 'departements.id')
    //             ->where('departements.instansi_id', $institutionId) // 🔥 filter instansi
    //             ->select('departements.nama as nama_bidang', DB::raw('COUNT(*) as jumlah'))
    //             ->groupBy('departements.id', 'departements.nama')
    //             ->get(),

    //         'upcomingSchedules' => $stockOpnameSessions->clone()
    //             ->with('departement')
    //             ->whereNotIn('status', ['completed', 'cancelled'])
    //             ->orderBy('tanggal_dijadwalkan')
    //             ->limit(5)
    //             ->get(),

    //         'stockStatus' => [
    //             'selesai' => $stockOpnameSessions->clone()->where('status', 'selesai')->count(),
    //             'berlangsung' => $stockOpnameSessions->clone()->where('status', 'proses')->count(),
    //             'belum' => $stockOpnameSessions->clone()->whereIn('status', ['draft', 'dijadwalkan'])->count(),
    //             // 'belum' => $stockOpnameSessions->clone()->where('status', 'draft')->count(),
    //             'total' => $stockOpnameSessions->clone()->count(),
    //         ],

    //         'recentActivities' => $activities->clone()->latest()->limit(5)->get(),
    //         'activities' => $activities->clone()->latest()->paginate(10),
    //     ]);
    // }
    // public function dashboard()
    // {
    //     // $totalAssets = Asset::count();
    //     // $tersedia = Asset::where('status', 'tersedia')->count();
    //     // $dipakai = Asset::where('status', 'dipakai')->count();
    //     // $activities = Activity::latest()->paginate(10);
    //     $user = auth()->user();
    //     $departmentId = $user->employee->department_id;

    //     // 2. Filter aset berdasarkan departemen
    //     $assetsInDepartment = Asset::where('department_id', $departmentId);

    //     $totalAssets = $assetsInDepartment->count();
    //     $tersedia = $assetsInDepartment->clone()->where('status', 'tersedia')->count();
    //     $dipakai = $assetsInDepartment->clone()->where('status', 'dipakai')->count();

    //     // 3. Filter log aktivitas berdasarkan aset di departemen tersebut
    //     $activities = Activity::where('subject_type', Asset::class)
    //         ->whereHasMorph('subject', [Asset::class], function ($query) use ($departmentId) {
    //             $query->where('department_id', $departmentId);
    //         })
    //         ->latest()
    //         ->paginate(10);
    //     return view('subadmin.dashboard', compact('totalAssets', 'tersedia', 'dipakai', 'activities'));
    // }
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
