<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Models\AssetUsage;
use App\Models\Asset;
use App\Models\Employee;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AssetUsageController extends Controller
{
    public function __construct()
    {
        // Menerapkan policy ke semua method resource controller secara otomatis
        $this->authorizeResource(AssetUsage::class, 'asset_usage');
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $user = auth()->user();
    //     $departmentId = $user->employee?->department_id;
    //     // 2. Persiapan Query: Siapkan query dasar
    //     $baseQuery = AssetUsage::with(['asset', 'user', 'department']);

    //     // 3. Scoping Query: Filter data berdasarkan peran pengguna
    //     if ($user->role === 'subadmin') {
    //         // Subadmin melihat semua usage di departemennya
    //         $baseQuery->whereHas('asset', function ($query) use ($departmentId) {
    //             $query->where('department_id', $departmentId);
    //         });
    //     } elseif ($user->role === 'user') {
    //         // User hanya melihat usage miliknya sendiri
    //         $employeeId = $user->employee?->id;
    //         $baseQuery->where('used_by', $employeeId);
    //     }



    //     // 4. Eksekusi Query: Clone dan paginate untuk setiap jenis aset
    //     $usagesBergerak = (clone $baseQuery)->whereHas('asset', function ($query) {
    //         $query->where('jenis_aset', 'bergerak');
    //     })->latest()->paginate(10, ['*'], 'bergerak_page');

    //     $usagesTidakBergerak = (clone $baseQuery)->whereHas('asset', function ($query) {
    //         $query->where('jenis_aset', 'tidak_bergerak');
    //     })->latest()->paginate(10, ['*'], 'tidak_bergerak_page');

    //     $usagesHabisPakai = (clone $baseQuery)->whereHas('asset', function ($query) {
    //         $query->where('jenis_aset', 'habis_pakai');
    //     })->latest()->paginate(10, ['*'], 'habis_pakai_page');

    //     if ($user->role === 'subadmin') {
    //         return view('usage.bidang.index', compact(
    //             'usagesBergerak',
    //             'usagesTidakBergerak',
    //             'usagesHabisPakai'
    //         ));
    //     } elseif ($user->role === 'user') {
    //         return view('usage.user.index', compact(
    //             'usagesBergerak',
    //             'usagesTidakBergerak',
    //             'usagesHabisPakai'
    //         ));
    //     }
    // }
    public function index(Request $request)
    {
        $user = auth()->user();
        $activeTab = $request->input('tab', 'bergerak');

        // Ambil parameter pencarian per tab
        $searchBergerak = $request->input('search_bergerak');
        $searchTidakBergerak = $request->input('search_tidak_bergerak');
        $searchHabisPakai = $request->input('search_habis_pakai');

        // Query dasar dengan relasi
        $baseQuery = AssetUsage::with(['asset', 'user', 'department']);

        // Scoping berdasarkan peran
        if ($user->role === 'subadmin') {
            $departmentId = $user->employee?->department_id;
            $baseQuery->whereHas('asset', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
        } elseif ($user->role === 'user') {
            $employeeId = $user->employee?->id;
            $baseQuery->where('used_by', $employeeId);
        }

        // --- Aset Bergerak ---
        $usagesBergerakQuery = (clone $baseQuery)->whereHas('asset', function ($query) {
            $query->where('jenis_aset', 'bergerak');
        });

        if ($searchBergerak) {
            $usagesBergerakQuery->where(function ($q) use ($searchBergerak) {
                $q->whereHas('asset', function ($subq) use ($searchBergerak) {
                    $subq->where('kode', 'like', "%{$searchBergerak}%")
                        ->orWhere('nama_aset', 'like', "%{$searchBergerak}%")
                        ->orWhere('start_date', 'like', "%{$searchBergerak}%")
                        ->orWhere('tujuan_penggunaan', 'like', "%{$searchBergerak}%");
                })
                    ->orWhereHas('user', function ($subq) use ($searchBergerak) {
                        $subq->where('nama', 'like', "%{$searchBergerak}%");
                    });
            });
        }

        $usagesBergerak = $usagesBergerakQuery->latest()
            ->paginate(10, ['*'], 'bergerak_page')
            ->appends($request->except(['search_tidak_bergerak', 'search_habis_pakai']));

        // --- Aset Tidak Bergerak ---
        $usagesTidakBergerakQuery = (clone $baseQuery)->whereHas('asset', function ($query) {
            $query->where('jenis_aset', 'tidak_bergerak');
        });

        if ($searchTidakBergerak) {
            $usagesTidakBergerakQuery->where(function ($q) use ($searchTidakBergerak) {
                $q->whereHas('asset', function ($subq) use ($searchTidakBergerak) {
                    $subq->where('kode', 'like', "%{$searchTidakBergerak}%")
                        ->orWhere('nama_aset', 'like', "%{$searchTidakBergerak}%")
                        ->orWhere('start_date', 'like', "%{$searchTidakBergerak}%")
                        ->orWhere('tujuan_penggunaan', 'like', "%{$searchTidakBergerak}%");
                })
                    ->orWhereHas('user', function ($subq) use ($searchTidakBergerak) {
                        $subq->where('nama', 'like', "%{$searchTidakBergerak}%");
                    });
            });
        }

        $usagesTidakBergerak = $usagesTidakBergerakQuery->latest()
            ->paginate(10, ['*'], 'tidak_bergerak_page')
            ->appends($request->except(['search_bergerak', 'search_habis_pakai']));

        // --- Aset Habis Pakai ---
        $usagesHabisPakaiQuery = (clone $baseQuery)->whereHas('asset', function ($query) {
            $query->where('jenis_aset', 'habis_pakai');
        });

        if ($searchHabisPakai) {
            $usagesHabisPakaiQuery->where(function ($q) use ($searchHabisPakai) {
                $q->whereHas('asset', function ($subq) use ($searchHabisPakai) {
                    $subq->where('kode', 'like', "%{$searchHabisPakai}%")
                        ->orWhere('nama_aset', 'like', "%{$searchHabisPakai}%")
                        ->orWhere('start_date', 'like', "%{$searchHabisPakai}%")
                        ->orWhere('tujuan_penggunaan', 'like', "%{$searchHabisPakai}%");
                })
                    ->orWhereHas('user', function ($subq) use ($searchHabisPakai) {
                        $subq->where('nama', 'like', "%{$searchHabisPakai}%");
                    });
            });
        }

        $usagesHabisPakai = $usagesHabisPakaiQuery->latest()
            ->paginate(10, ['*'], 'habis_pakai_page')
            ->appends($request->except(['search_bergerak', 'search_tidak_bergerak']));

        // Tentukan view berdasarkan role
        $view = $user->role === 'subadmin'
            ? 'usage.bidang.index'
            : 'usage.user.index';

        return view($view, compact(
            'usagesBergerak',
            'usagesTidakBergerak',
            'usagesHabisPakai',
            'activeTab'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     // atur agar hanya asset di departemen itu
    //     $assets = Asset::where('status', 'tersedia')->get();
    //     $employees = Employee::all();
    //     $departements = Departement::all();

    //     return view('usage.bidang.create', compact('assets', 'employees', 'departements'));
    // }
    public function create($jenisAset)
    {
        $user = Auth::user();
        $departmentId = $user->employee?->department_id;

        // $validJenisAset = ['bergerak', 'tidak_bergerak', 'habis_pakai'];

        $assetsQuery = Asset::where('status', 'tersedia')
            ->where('department_id', $departmentId);

        // if ($jenisAset && in_array($jenisAset, $validJenisAset)) {
        $assetsQuery->where('jenis_aset', $jenisAset);
        // }
        $assets = $assetsQuery->get();
        $employees = Employee::where('department_id', $departmentId)->get();
        $departements = Departement::where('id', $departmentId)->get();

        if (isAsetLocked($departmentId, $jenisAset)) {
            return redirect(routeForRole('asset-usage', 'index'))->with('error', 'Tidak dapat meminjam aset. Stock opname untuk jenis aset ini sedang berlangsung.');
        }

        return view('usage.bidang.create', compact(
            'assets',
            'employees',
            'departements',
            'jenisAset'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $asset = Asset::find($request->asset_id);
        if (!$asset) {
            return back()->withInput()->withErrors(['asset_id' => 'Asset tidak ditemukan.']);
        }

        // Jika aset bukan habis pakai, kita set jumlahnya menjadi 1 secara otomatis
        // dan tidak mewajibkan input dari user.
        if ($asset->jenis_aset !== 'habis_pakai') {
            $request->merge(['jumlah_digunakan' => 1]);
        }



        $validated = $request->validate([
            'asset_id' => 'required|exists:aset,id',
            'used_by' => 'required|exists:employees,id',
            'start_date' => 'required|date|before_or_equal:today',
            'tujuan_penggunaan' => 'nullable|string|max:255',
            'jumlah_digunakan' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ], [
            'asset_id.exists' => 'Asset tidak ditemukan.',
            'used_by.exists' => 'Karyawan tidak ditemukan.',
            'start_date.before_or_equal' => 'Tanggal mulai tidak boleh melebihi hari ini.',
            'jumlah_digunakan.required' => 'Jumlah penggunaan wajib diisi untuk aset habis pakai.',
            'jumlah_digunakan.min' => 'Jumlah penggunaan minimal adalah 1.',
        ]);
        $user = auth()->user();
        // ambil employee id dari user yang membuat (subadmin)
        $picEmployeeId = $user->employee?->id;

        $validated['pic_id'] = $picEmployeeId;

        // simpan
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, $asset->jenis_aset)) {
            return redirect(routeForRole('asset-usage', 'index'))->with('error', 'Tidak dapat meminjam aset. Stock opname untuk jenis aset ini sedang berlangsung.');
        }

        $jumlahDiminta = $validated['jumlah_digunakan'];

        DB::beginTransaction();
        try {
            // Menentukan status untuk AssetUsage berdasarkan jenis aset
            if ($asset->jenis_aset === 'habis_pakai') {
                $validated['status'] = 'selesai'; // Status baru untuk habis pakai
                $validated['end_date'] = now();   // Langsung ada tanggal selesai

                if ($asset->jumlah < $jumlahDiminta) {
                    throw new \Exception('Stok aset tidak mencukupi. Stok tersedia: ' . $asset->jumlah);
                }
                $asset->decrement('jumlah', $jumlahDiminta);
                if ($asset->fresh()->jumlah <= 0) {
                    $asset->update(['status' => 'habis']);
                }
            } else {
                $validated['status'] = 'dipakai'; // Status untuk aset yang bisa dikembalikan

                if ($asset->jumlah < $jumlahDiminta) {
                    throw new \Exception('Jumlah aset tidak mencukupi (Stok: ' . $asset->jumlah . ').');
                }
                if ($asset->status !== 'tersedia') {
                    throw new \Exception('Asset tidak tersedia untuk digunakan. Status saat ini: ' . $asset->status);
                }
                $asset->update(['status' => 'dipakai']);
            }

            $validated['department_id'] = auth()->user()->employee?->department?->id;
            AssetUsage::create($validated);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Gunakan error yang lebih umum jika bukan karena validasi
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect(routeForRole('asset-usage', 'index'))
            ->with('success', 'Penggunaan asset berhasil dicatat.');
    }

    public function show(AssetUsage $assetUsage)
    {
        // Otorisasi untuk memastikan pengguna boleh melihat data ini
        $this->authorize('view', $assetUsage);
        $user = auth()->user();
        // Eager load semua relasi yang mungkin dibutuhkan
        $assetUsage->load([
            'asset.bergerak',
            'asset.tidakBergerak',
            'asset.habisPakai',
            'user',
            'department'
        ]);

        $jenisAset = $assetUsage->asset->jenis_aset;
        $viewName = '';

        // Tentukan nama view yang akan digunakan berdasarkan jenis aset
        if ($jenisAset === 'bergerak') {
            $viewName = 'usage.show.show_bergerak';
        } elseif ($jenisAset === 'tidak_bergerak') {
            $viewName = 'usage.show.show_tidak_bergerak';
        } elseif ($jenisAset === 'habis_pakai') {
            $viewName = 'usage.show.show_habis_pakai';
        } else {
            // Fallback jika jenis aset tidak dikenali
            abort(404, 'Jenis aset tidak valid.');
        }

        return view($viewName, compact('assetUsage', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetUsage $assetUsage)
    {
        $assetUsage->load(['asset', 'user', 'department']);
        $assets = Asset::all();
        $employees = Employee::all();
        $departements = Departement::all();

        return view('asset-usage.edit', compact('assetUsage', 'assets', 'employees', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetUsage $assetUsage)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:aset,id',
            'used_by' => 'required|exists:employees,id',
            'department_id' => 'required|exists:departements,id',
            'start_date' => 'required|date',
            'tujuan_penggunaan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'asset_id.exists' => 'Asset tidak ditemukan.',
            'used_by.exists' => 'Employee tidak ditemukan.',
            'department_id.exists' => 'Departement tidak ditemukan.',
            'tujuan_penggunaan.required' => 'Tujuan penggunaan wajib diisi.',
        ]);

        // Validasi jika status masih dipakai dan asset_id berubah
        if ($assetUsage->status === 'dipakai' && $assetUsage->asset_id != $request->asset_id) {
            $newAsset = Asset::find($request->asset_id);
            if ($newAsset->status !== 'tersedia') {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['asset_id' => 'Asset baru tidak tersedia untuk digunakan.']);
            }

            // Update status asset lama ke tersedia
            $oldAsset = Asset::find($assetUsage->asset_id);
            if ($oldAsset) {
                $oldAsset->update(['status' => 'tersedia']);
            }

            // Update status asset baru ke dipakai
            $newAsset->update(['status' => 'dipakai']);
        }

        $assetUsage->update($validated);

        return redirect(routeForRole('asset-usage', 'index'))
            ->with('success', 'Penggunaan asset berhasil diperbarui.');

        // return redirect()->route('superadmin.asset-usage.index')
        //     ->with('success', 'Penggunaan asset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetUsage $assetUsage)
    {
        try {
            $oldAssetId = $assetUsage->asset_id;
            $oldStatus = $assetUsage->status;

            $assetUsage->delete();

            // Update status asset jika diperlukan
            if ($oldStatus === 'dipakai') {
                $asset = Asset::find($oldAssetId);
                if ($asset) {
                    $asset->update(['status' => 'tersedia']);
                }
            }
            return redirect(routeForRole('asset-usage', 'index'))
                ->with('success', 'Penggunaan asset berhasil dihapus.');

            // return redirect()->route('superadmin.asset-usage.index')
            //     ->with('success', 'Penggunaan asset berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect(routeForRole('asset-usage', 'index'))
                ->with('error', 'Gagal menghapus penggunaan asset.');

            // return redirect()->route('superadmin.asset-usage.index')
            //     ->with('error', 'Gagal menghapus penggunaan asset.');
        }
    }

    /**
     * Return asset
     */
    public function returnAsset(AssetUsage $assetUsage)
    {
        $user = auth()->user();
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, $assetUsage->asset->jenis_aset)) {
            return redirect(routeForRole('asset-usage', 'index'))->with('error', 'Tidak dapat mengembalikan aset. Stock opname untuk jenis aset ini sedang berlangsung.');
        }
        // Pastikan aset yang akan dikembalikan bukan jenis habis pakai.
        if ($assetUsage->asset->jenis_aset === 'habis_pakai') {
            return redirect()->back()
                ->with('error', 'Aset habis pakai tidak dapat dikembalikan karena bersifat konsumsi.');
        }
        $this->authorize('return', $assetUsage);
        if ($assetUsage->status !== 'dipakai') {
            return redirect()->back()
                ->with('error', 'Asset tidak sedang digunakan.');
        }

        $assetUsage->update([
            'status' => 'dikembalikan',
            'end_date' => now(),
        ]);

        // Update status asset menjadi 'tersedia'
        $asset = Asset::find($assetUsage->asset_id);
        if ($asset) {
            $asset->update(['status' => 'tersedia']);
        }

        return redirect()->back()
            ->with('success', 'Asset berhasil dikembalikan.');
    }

    /**
     * Show active usages
     */
    public function active()
    {
        $usages = AssetUsage::with(['asset', 'user', 'department'])
            ->where('status', 'dipakai')
            ->latest()
            ->paginate(10);

        return view('asset-usage.active', compact('usages'));
    }
}
