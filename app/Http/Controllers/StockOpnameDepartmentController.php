<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// \Illuminate\Support\Facades\
use App\Models\StockOpnameDetail;
use App\Models\Asset;
use App\Models\Departement;
use App\Models\CategoryGroup;
use App\Models\User;
use App\Models\StockOpnameSession;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class StockOpnameDepartmentController extends Controller
{


    public function index()
    {
        // Gunakan Carbon::now() untuk membandingkan waktu lengkap
        $currentTime = Carbon::now();

        $overdueSessions = StockOpnameSession::where('department_id', auth()->user()->employee?->department_id)
            ->whereIn('status', ['dijadwalkan', 'proses'])
            ->where('tanggal_deadline', '<', $currentTime) // Bandingkan dengan waktu lengkap saat ini
            ->get();

        foreach ($overdueSessions as $session) {
            DB::transaction(function () use ($session) {
                // Langkah 1: Tandai sesi sebagai selesai
                $session->status = 'selesai';
                $session->tanggal_selesai = now();
                $session->catatan = trim(($session->catatan ?? '') . ' Sesi ditutup otomatis karena melewati batas waktu.');
                $session->save();

                // Langkah 2: Proses Aset BERGERAK & TIDAK BERGERAK yang belum dicek (status_fisik null)
                $unprocessedMovable = $session->details()
                    ->whereNull('status_fisik')
                    ->whereHas('asset', fn($q) => $q->whereIn('jenis_aset', ['bergerak', 'tidak_bergerak']))
                    ->with('asset')
                    ->get();

                foreach ($unprocessedMovable as $detail) {
                    $statusLama = $detail->status_lama;
                    $jumlahSistem = $detail->jumlah_sistem;

                    $detail->status_fisik = $statusLama;
                    $detail->jumlah_fisik = $jumlahSistem;
                    $detail->save();

                    $asset = $detail->asset;
                    if ($asset) {
                        $asset->status = $statusLama;
                        $asset->jumlah = $jumlahSistem;
                        $asset->save();
                    }
                }

                // Langkah 3: Proses Aset HABIS PAKAI yang belum dihitung (jumlah_fisik null)
                $unprocessedConsumable = $session->details()
                    ->whereNull('jumlah_fisik')
                    ->whereHas('asset', fn($q) => $q->where('jenis_aset', 'habis_pakai'))
                    ->with('asset')
                    ->get();

                foreach ($unprocessedConsumable as $detail) {
                    $jumlahSistem = $detail->jumlah_sistem;
                    $statusLama = $detail->status_lama;

                    $detail->jumlah_fisik = $jumlahSistem;
                    $detail->status_fisik = $statusLama;
                    $detail->save();

                    $asset = $detail->asset;
                    if ($asset) {
                        $asset->jumlah = $jumlahSistem;
                        $asset->status = $statusLama;
                        $asset->save();
                    }
                }
            });
        }

        // Kode untuk menampilkan daftar sesi (tidak berubah)
        $user = auth()->user();
        $sessions = StockOpnameSession::with(['scheduler', 'departement', 'details.asset'])
            ->where('department_id', $user->employee?->department_id)
            ->whereIn('status', ['dijadwalkan', 'proses', 'selesai'])
            ->latest()
            ->paginate(10);

        return view('opname.bidang.index', compact('sessions', 'user'));
    }


    public function show(Request $request, StockOpnameSession $opname)
    {
        if (in_array($opname->status, ['draft', 'cancelled', 'dijadwalkan'])) {
            abort(404);
        }

        // Ambil keyword pencarian dari form (GET)
        $search = $request->input('search');

        // Ambil semua detail, tapi kalau ada pencarian, filter berdasarkan nama_aset / kode
        $detailsQuery = $opname->details()->with('asset');

        if (!empty($search)) {
            $detailsQuery->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', '%' . $search . '%')
                    ->orWhere('kode', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($qc) use ($search) {
                        $qc->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        $filteredDetails = $detailsQuery->get();

        // Load juga relasi scheduler agar view tetap utuh
        $opname->load('scheduler');

        return view('opname.bidang.show', [
            'opname' => $opname,
            'filteredDetails' => $filteredDetails,
            'search' => $search,
        ]);
    }


    public function update(Request $request, StockOpnameSession $opname)
    {
        $request->validate([
            'statuses' => 'nullable|array',
            'jumlah_fisik' => 'nullable|array',
        ]);

        // **LANGKAH 1: VALIDASI KELENGKAPAN SEBELUM MEMPROSES**
        // Cek apakah ada item yang belum diisi sesuai jenis asetnya.
        $isIncomplete = $opname->details()->where(function ($query) {
            // Kondisi 1: Aset (tidak) bergerak yang status fisiknya null
            $query->where(function ($q) {
                $q->whereNull('status_fisik')
                    ->whereHas('asset', function ($subQuery) {
                        $subQuery->whereIn('jenis_aset', ['bergerak', 'tidak_bergerak']);
                    });
            })
                // ATAU
                // Kondisi 2: Aset habis pakai yang jumlah fisiknya null
                ->orWhere(function ($q) {
                    $q->whereNull('jumlah_fisik')
                        ->whereHas('asset', function ($subQuery) {
                            $subQuery->where('jenis_aset', 'habis_pakai');
                        });
                });
        })->exists(); // Cukup cek apakah ada, tidak perlu ambil datanya

        // Jika ditemukan ada yang belum lengkap, kembalikan dengan peringatan.
        if ($isIncomplete) {
            return redirect()->back()
                ->withInput($request->input()) // Mengembalikan input yang sudah diisi
                ->with('error', 'Peringatan: Masih ada aset yang belum diperiksa atau dihitung. Silakan lengkapi semua item sebelum  menyelesaikan sesi opname.');
        }

        // **LANGKAH 2: JIKA LENGKAP, LANJUTKAN PROSES UPDATE**
        DB::beginTransaction();
        try {
            // Loop ini sekarang aman, karena kita tahu semua item sudah diisi
            foreach ($opname->details as $detail) {
                $asset = $detail->asset;
                if (!$asset) continue;

                $detailId = $detail->id;
                $assetType = $asset->jenis_aset;

                if (in_array($assetType, ['bergerak', 'tidak_bergerak'])) {
                    if ($request->has("statuses.{$detailId}") && !empty($request->statuses[$detailId])) {
                        $statusFisikInput = $request->statuses[$detailId];

                        $detail->status_fisik = $statusFisikInput;
                        $asset->status = $statusFisikInput;
                        $detail->jumlah_fisik = ($statusFisikInput === 'hilang') ? 0 : 1;
                        $asset->jumlah = ($statusFisikInput === 'hilang') ? 0 : 1;

                        $detail->save();
                        $asset->save();
                    }
                } elseif ($assetType === 'habis_pakai') {
                    if ($request->has("jumlah_fisik.{$detailId}")) {
                        $jumlahFisikInput = (int) $request->jumlah_fisik[$detailId];

                        $detail->jumlah_fisik = $jumlahFisikInput;
                        $asset->jumlah = $jumlahFisikInput;
                        $detail->status_fisik = ($jumlahFisikInput == 0) ? 'habis' : 'tersedia';
                        $asset->status = ($jumlahFisikInput == 0) ? 'habis' : 'tersedia';

                        $detail->save();
                        $asset->save();
                    }
                }
            }

            $opname->update([
                'status' => 'selesai',
                'tanggal_selesai' => now(),
            ]);

            DB::commit();

            return redirect(routeForRole('opname', 'index', $opname->id))
                ->with('success', 'Stock opname berhasil diselesaikan dan data aset telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // public function update(Request $request, StockOpnameSession $opname)
    // {
    //     $request->validate([
    //         'statuses' => 'nullable|array',
    //         'jumlah_fisik' => 'nullable|array',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         foreach ($opname->details as $detail) {
    //             $asset = $detail->asset;
    //             if (!$asset) continue;

    //             $detailId = $detail->id;
    //             $assetType = $asset->jenis_aset;

    //             if (in_array($assetType, ['bergerak', 'tidak_bergerak'])) {
    //                 if ($request->has("statuses.{$detailId}") && !empty($request->statuses[$detailId])) {
    //                     $statusFisikInput = $request->statuses[$detailId];
    //                     // tambahan ku
    //                     if ($statusFisikInput == null) {
    //                         $statusFisikInput = 'hilang';
    //                     }

    //                     $detail->status_fisik = $statusFisikInput;
    //                     $asset->status = $statusFisikInput;

    //                     $jumlahFisikHasil = ($statusFisikInput === 'hilang') ? 0 : 1;
    //                     $detail->jumlah_fisik = $jumlahFisikHasil;
    //                     $asset->jumlah = $jumlahFisikHasil;

    //                     $detail->save();
    //                     $asset->save();
    //                 }
    //             } elseif ($assetType === 'habis_pakai') {
    //                 if ($request->has("jumlah_fisik.{$detailId}")) {
    //                     $jumlahFisikInput = (int) $request->jumlah_fisik[$detailId];
    //                     // tambahan ku
    //                     if ($jumlahFisikInput == null) {
    //                         $jumlahFisikInput = 0;
    //                     }

    //                     $detail->jumlah_fisik = $jumlahFisikInput;
    //                     $asset->jumlah = $jumlahFisikInput;

    //                     $statusFisikHasil = ($jumlahFisikInput == 0) ? 'habis' : 'tersedia';
    //                     $detail->status_fisik = $statusFisikHasil;
    //                     $asset->status = $statusFisikHasil;

    //                     $detail->save();
    //                     $asset->save();
    //                 }
    //             }
    //         }

    //         $opname->update([
    //             'status' => 'selesai',
    //             'tanggal_selesai' => now(),
    //         ]);

    //         DB::commit();

    //         return redirect(routeForRole('opname', 'index', $opname->id))
    //             ->with('success', 'Stock opname berhasil disimpan dan data aset telah diperbarui.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function complete(Request $request, StockOpnameSession $opname)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string',
        ]);

        if ($opname->status !== 'draft') {
            return redirect()->back()->with('error', 'Sesi hanya bisa dimulai jika statusnya draft.');
        }

        $opname->update([
            'status' => 'dijadwalkan',
            'catatan' => $request->catatan ?? 'Stock opname untuk ' . $opname->departement->nama,
        ]);

        return redirect()->back()->with('success', 'Sesi stock opname berhasil dimulai.');
    }

    public function getAssetDetailsByCode(string $kode): JsonResponse
    {
        $asset = Asset::where('kode', $kode)->first();

        if (!$asset) {
            return response()->json(['message' => 'Aset tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $asset->id,
            'kode' => $asset->kode,
            'nama_aset' => $asset->nama_aset,
            'jenis_aset' => $asset->jenis_aset,
        ]);
    }

    public function startOpname(StockOpnameSession $session)
    {
        // Ambil tanggal dari kolom datetime 'tanggal_dijadwalkan' dan bandingkan dengan tanggal hari ini
        // ->startOfDay() mengatur waktu ke 00:00:00, ->endOfDay() ke 23:59:59.999999
        // Kita bisa membandingkan tanggal secara langsung.
        $tanggalJadwal = $session->tanggal_dijadwalkan->toDateString(); // Ambil hanya bagian tanggal
        $tanggalHariIni = Carbon::today()->toDateString(); // Ambil hanya bagian tanggal hari ini

        if ($tanggalHariIni < $tanggalJadwal) {
            return response()->json([
                'message' => 'Belum saatnya, opname dijadwalkan pada ' .
                    $session->tanggal_dijadwalkan->format('d-m-Y') . '.' // Format tetap menampilkan tanggal
            ], 403);
        }

        if ($session->status === 'dijadwalkan') {
            DB::transaction(function () use ($session) {
                $session->status = 'proses';
                $session->tanggal_dimulai = now(); // `now()` mengambil waktu sekarang (tanggal dan jam)
                $session->save();
            });

            return response()->json(['message' => 'Sesi opname berhasil dimulai.']);
        }

        return response()->json(['message' => 'Sesi opname sudah berjalan atau telah selesai.'], 409);
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password terverifikasi.'], 200);
        }

        return response()->json(['message' => 'Password yang Anda masukkan salah.'], 422);
    }



    public function updateItem(Request $request, StockOpnameDetail $detail)
    {
        Log::info('Fungsi updateItem DIPANGGIL. Detail ID: ' . $detail->id);
        // Optional: policy/authorize
        // $this->authorize('update', $detail);
        activity()->disableLogging();
        $user = auth()->user();
        if ($detail->stockOpname->department_id !== $user->employee?->department_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($detail->stockOpname->status !== 'proses') {
            return response()->json(['message' => 'Sesi opname tidak aktif'], 400);
        }

        $asset = $detail->asset;
        if (!$asset) {
            return response()->json(['message' => 'Aset tidak ditemukan'], 404);
        }

        try {
            DB::transaction(function () use ($request, $detail, $asset) {
                if (in_array($asset->jenis_aset, ['bergerak', 'tidak_bergerak'])) {
                    $validated = $request->validate(['status_fisik' => 'required|string']);
                    $detail->status_fisik = $validated['status_fisik'];
                    $detail->jumlah_fisik = ($validated['status_fisik'] === 'hilang') ? 0 : 1;
                } elseif ($asset->jenis_aset === 'habis_pakai') {
                    $validated = $request->validate(['jumlah_fisik' => 'required|integer|min:0']);
                    $detail->jumlah_fisik = $validated['jumlah_fisik'];
                    $detail->status_fisik = ($validated['jumlah_fisik'] == 0) ? 'habis' : 'tersedia';
                }
                $detail->save();
            });
            activity()->enableLogging();

            return response()->json(['message' => 'Data berhasil disimpan.', 'timestamp' => now()->toTimeString()]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }
    public function validateCompletion(StockOpnameSession $opname)
    {
        $isIncomplete = $opname->details()->where(function ($query) {
            $query->where(function ($q) {
                $q->whereNull('status_fisik')
                    ->whereHas('asset', function ($subQuery) {
                        $subQuery->whereIn('jenis_aset', ['bergerak', 'tidak_bergerak']);
                    });
            })
                ->orWhere(function ($q) {
                    $q->whereNull('jumlah_fisik')
                        ->whereHas('asset', function ($subQuery) {
                            $subQuery->where('jenis_aset', 'habis_pakai');
                        });
                });
        })->exists();

        if ($isIncomplete) {
            return response()->json([
                'message' => 'Peringatan: Masih ada aset yang belum diperiksa atau dihitung. Silakan lengkapi semua item sebelum menyelesaikan sesi opname.'
            ], 422); // 422 Unprocessable Entity
        }

        return response()->json(['message' => 'Data opname sudah lengkap.']);
    }
}
