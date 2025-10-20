<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Asset;
use Spatie\Activitylog\Models\Activity;
use App\Models\Institution;
use App\Models\User;


class UserDashboardController extends Controller
{

    // public function dashboard()
    // {
    //     $user = Auth::user();
    //     $activities = collect(); // Default koleksi kosong

    //     // === LOGIKA FILTER ASET & LOG ===
    //     $assetQuery = Asset::query();
    //     $activityQuery = Activity::query()->with(['causer.employee', 'subject']);

    //     // Cek apakah pengguna adalah Kepala Instansi
    //     $isHeadOfInstitution = false;
    //     if ($user->employee) {
    //         $institution = Institution::where('kepala_instansi_id', $user->employee->id)->first();
    //         if ($institution) {
    //             $isHeadOfInstitution = true;
    //             $institutionId = $institution->id;

    //             // Filter Aset untuk Kepala Instansi
    //             $assetQuery->whereHas('departement', function ($q) use ($institutionId) {
    //                 $q->where('instansi_id', $institutionId);
    //             });

    //             // Filter Log untuk Kepala Instansi
    //             $activityQuery->where(function ($q) use ($institutionId) {
    //                 $q->whereHasMorph('subject', [\App\Models\Asset::class], function ($subQuery) use ($institutionId) {
    //                     $subQuery->whereHas('departement', function ($deptQuery) use ($institutionId) {
    //                         $deptQuery->where('instansi_id', $institutionId);
    //                     });
    //                 })->orWhereHasMorph('causer', [\App\Models\User::class], function ($userQuery) use ($institutionId) {
    //                     $userQuery->whereHas('employee', function ($empQuery) use ($institutionId) {
    //                         $empQuery->where('institution_id', $institutionId);
    //                     });
    //                 });
    //             });

    //             // === PERUBAHAN DI SINI: Gunakan paginate() bukan take(5)->get() ===
    //             $activities = $activityQuery->latest()->paginate(10)->withQueryString();
    //         }
    //     }

    //     // Jika bukan kepala instansi, user biasa hanya melihat aset di departemennya
    //     if (!$isHeadOfInstitution && $user->employee?->department_id) {
    //         $departmentId = $user->employee->department_id;
    //         $assetQuery->where('department_id', $departmentId);
    //     } elseif (!$isHeadOfInstitution) {
    //         $assetQuery->whereRaw('1 = 0');
    //     }
    //     // === HITUNG STATISTIK BERDASARKAN QUERY YANG SUDAH DIFILTER ===
    //     $stats = [
    //         'aset_bergerak'     => $assetQuery->clone()->where('jenis_aset', 'bergerak')->count(),
    //         'aset_tetap'        => $assetQuery->clone()->where('jenis_aset', 'tidak_bergerak')->count(),
    //         'aset_habis_pakai'  => $assetQuery->clone()->where('jenis_aset', 'habis_pakai')->count(),
    //     ];

    //     return view('user.dashboard', compact('stats', 'activities', 'isHeadOfInstitution'));
    // }
    public function dashboard()
    {
        $user = Auth::user();
        $activities = collect(); // Default koleksi kosong
        $isHeadOfInstitution = false;
        $isHeadOfDepartment = false;

        // === LOGIKA FILTER ASET & LOG ===
        $assetQuery = Asset::query();
        $activityQuery = Activity::query()->with(['causer.employee', 'subject']);

        if ($user->employee) {
            // Cek apakah pengguna adalah Kepala Instansi
            $institution = Institution::where('kepala_instansi_id', $user->employee->id)->first();
            if ($institution) {
                $isHeadOfInstitution = true;
                $institutionId = $institution->id;

                // Filter Aset untuk Kepala Instansi
                $assetQuery->whereHas('departement', function ($q) use ($institutionId) {
                    $q->where('instansi_id', $institutionId);
                });

                // Filter Log untuk Kepala Instansi
                $activityQuery->where(function ($q) use ($institutionId) {
                    $q->whereHasMorph('subject', [Asset::class], function ($subQuery) use ($institutionId) {
                        $subQuery->whereHas('departement', function ($deptQuery) use ($institutionId) {
                            $deptQuery->where('instansi_id', $institutionId);
                        });
                    })->orWhereHasMorph('causer', [User::class], function ($userQuery) use ($institutionId) {
                        $userQuery->whereHas('employee', function ($empQuery) use ($institutionId) {
                            $empQuery->where('institution_id', $institutionId);
                        });
                    });
                });

                $activities = $activityQuery->latest()->paginate(10)->withQueryString();
            }

            // Cek apakah pengguna adalah Kepala Departemen (jika bukan kepala instansi)
            if (!$isHeadOfInstitution) {
                $department = Departement::where('kepala_bidang_id', $user->employee->id)->first();
                if ($department) {
                    $isHeadOfDepartment = true;
                    $departmentId = $department->id;

                    // Filter Aset untuk Kepala Departemen
                    $assetQuery->where('department_id', $departmentId);

                    // Filter Log untuk Kepala Departemen
                    $activityQuery->whereHasMorph('subject', [Asset::class], function ($query) use ($departmentId) {
                        $query->where('department_id', $departmentId);
                    });

                    $activities = $activityQuery->latest()->paginate(10)->withQueryString();
                }
            }
        }


        // Jika bukan kepala instansi/departemen, user biasa hanya melihat aset di departemennya
        if (!$isHeadOfInstitution && !$isHeadOfDepartment && $user->employee?->department_id) {
            $departmentId = $user->employee->department_id;
            $assetQuery->where('department_id', $departmentId);
        } elseif (!$isHeadOfInstitution && !$isHeadOfDepartment) {
            $assetQuery->whereRaw('1 = 0');
        }
        // === HITUNG STATISTIK BERDASARKAN QUERY YANG SUDAH DIFILTER ===
        $stats = [
            'aset_bergerak'     => $assetQuery->clone()->where('jenis_aset', 'bergerak')->count(),
            'aset_tetap'        => $assetQuery->clone()->where('jenis_aset', 'tidak_bergerak')->count(),
            'aset_habis_pakai'  => $assetQuery->clone()->where('jenis_aset', 'habis_pakai')->count(),
        ];

        return view('user.dashboard', compact('stats', 'activities', 'isHeadOfInstitution', 'isHeadOfDepartment'));
    }
    public function profil()
    {
        return view('layouts.profil');
    }
}
