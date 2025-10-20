<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Departement;
use App\Models\StockOpnameDetail;
use App\Models\StockOpnameSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    // public function index()
    // {
    //     $user = auth()->user();
    //     $institutionId = $user->employee->institution_id;

    //     $departements = Departement::where('instansi_id', $institutionId)->get();

    //     $sessions = StockOpnameSession::with(['scheduler', 'details'])
    //         ->latest()
    //         ->paginate(10);

    //     return view('opname.institution.index', compact('sessions', 'departements'));
    // }

    // public function index()
    // {
    //     $user = auth()->user();
    //     $institutionId = $user->employee->institution_id;

    //     // Query dasar untuk sesi di institusi pengguna
    //     $sessionsQuery = StockOpnameSession::whereHas('departement', function ($query) use ($institutionId) {
    //         $query->where('instansi_id', $institutionId);
    //     });

    //     // Menghitung statistik
    //     $overview = [
    //         'total' => $sessionsQuery->clone()->count(),
    //         'dijadwalkan' => $sessionsQuery->clone()->where('status', 'dijadwalkan')->count(),
    //         'proses' => $sessionsQuery->clone()->where('status', 'proses')->count(),
    //         'selesai' => $sessionsQuery->clone()->where('status', 'selesai')->count(),
    //     ];

    //     $departements = Departement::where('instansi_id', $institutionId)->get();

    //     // Mengambil data sesi untuk paginasi
    //     $sessions = $sessionsQuery->clone()->with(['scheduler', 'details'])
    //         ->latest()
    //         ->paginate(10);

    //     return view('opname.institution.index', compact('sessions', 'departements', 'overview'));
    // }

    public function index(Request $request)
    {
        $user = auth()->user();
        $institutionId = $user->employee->institution_id;

        // Ambil nilai filter dari request
        $filterJenisAset = $request->input('jenis_aset');
        $filterStatus = $request->input('status');

        // Query dasar untuk sesi di institusi pengguna
        $sessionsQuery = StockOpnameSession::whereHas('departement', function ($query) use ($institutionId) {
            $query->where('instansi_id', $institutionId);
        });

        // Terapkan filter Jenis Aset jika ada
        if ($filterJenisAset) {
            // Filter ini memeriksa apakah ADA detail dalam sesi yang cocok dengan jenis aset
            $sessionsQuery->whereHas('details.asset', function ($query) use ($filterJenisAset) {
                $query->where('jenis_aset', $filterJenisAset);
            });
        }

        // Terapkan filter Status jika ada
        if ($filterStatus) {
            $sessionsQuery->where('status', $filterStatus);
        }

        // Menghitung statistik (overview tidak terpengaruh filter)
        $overviewQuery = StockOpnameSession::whereHas('departement', function ($query) use ($institutionId) {
            $query->where('instansi_id', $institutionId);
        });
        $overview = [
            'total' => $overviewQuery->clone()->count(),
            'dijadwalkan' => $overviewQuery->clone()->where('status', 'dijadwalkan')->count(),
            'proses' => $overviewQuery->clone()->where('status', 'proses')->count(),
            'selesai' => $overviewQuery->clone()->where('status', 'selesai')->count(),
        ];

        $departements = Departement::where('instansi_id', $institutionId)->get();

        // Mengambil data sesi untuk paginasi dengan filter yang sudah diterapkan
        $sessions = $sessionsQuery->with(['scheduler', 'details'])
            ->latest()
            ->paginate(10)
            ->appends($request->query()); // <-- Penting untuk paginasi

        return view('opname.institution.index', compact('sessions', 'departements', 'overview'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_dijadwalkan' => 'required|date',
            'tanggal_deadline' => 'required|date|after_or_equal:tanggal_dijadwalkan',
            'department_id' => 'required|exists:departements,id',
            'jenis_aset' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $existingSession = StockOpnameSession::where('department_id', $request->department_id)
            ->whereNotIn('status', ['selesai', 'cancelled'])
            ->whereHas('details.asset', function ($query) use ($request) {
                $query->where('jenis_aset', $request->jenis_aset);
            })
            ->exists();

        if ($existingSession) {
            return back()
                ->with('error', 'Sesi opname aktif untuk departemen dan jenis aset ini sudah ada.')
                ->withInput();
        }

        $user = auth()->user();
        $departement = Departement::find($request->department_id);

        // if ($departement->kepala == null) {
        //     return back()->with('info', 'Departemen ini belum memiliki kepala.')->withInput();
        // }
        // if ($departement->user == null) {
        //     return back()->with('info', 'Departemen ini belum memiliki admin.')->withInput();
        // }

        $hasSubadmin = User::where('role', 'subadmin')
            ->whereHas('employee', function ($query) use ($departement) {
                $query->where('department_id', $departement->id);
            })
            ->exists();

        if (! $hasSubadmin) {
            return back()->with('info', 'Departemen ini belum memiliki subadmin.')->withInput();
        }

        try {
            DB::transaction(function () use ($request, $departement, $user) {
                // 1. Buat sesi opname
                $session = StockOpnameSession::create([
                    'nama' => 'Opname '.$departement->nama.' - '.$request->jenis_aset.' ('.$request->tanggal_dijadwalkan.')',
                    'scheduled_by' => $user->id,
                    'department_id' => $request->department_id,
                    'tanggal_dijadwalkan' => $request->tanggal_dijadwalkan,
                    'tanggal_deadline' => $request->tanggal_deadline,
                    'status' => 'draft',
                    'catatan' => $request->catatan ?? '',
                ]);

                // 2. Ambil semua aset yang cocok
                $assetsToOpname = Asset::where('department_id', $request->department_id)
                    ->where('jenis_aset', $request->jenis_aset)
                    ->get();

                if ($assetsToOpname->isEmpty()) {
                    // Batalkan sesi karena tidak ada aset
                    $session->delete();
                    throw new \Exception('Tidak ada aset yang ditemukan untuk departemen dan jenis aset yang dipilih.');
                }

                // 3. Buat detail untuk setiap aset
                foreach ($assetsToOpname as $asset) {
                    StockOpnameDetail::create([
                        'stock_opname_id' => $session->id,
                        'aset_id' => $asset->id,
                        'jumlah_sistem' => $asset->jumlah,
                        'jumlah_fisik' => null,
                        'status_lama' => $asset->status,
                        'status_fisik' => null,
                        // 'status_fisik' => $asset->status,
                        'checked_by' => $user->id,
                    ]);
                }
            });

            return redirect(routeForRole('opname', 'index'))
                ->with('success', 'Jadwal stock opname berhasil dibuat.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal membuat sesi stock opname: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StockOpnameSession $opname)
    {
        // Gunakan $opname karena route model binding
        $opname->load(['details', 'scheduler']); // Eager load relasi untuk efisiensi

        return view('opname.institution.show', compact('opname'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockOpnameSession $stockOpnameSession)
    {
        $stockOpnameSession->load('scheduler');
        $users = User::all();

        return view('stock-opname-sessions.edit', compact('stockOpnameSession', 'users'));
    }

    public function update(Request $request, StockOpnameSession $stockOpnameSession)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'scheduled_by' => 'required|exists:users,id',
            'tanggal_dijadwalkan' => 'required|date',
            'tanggal_dimulai' => 'nullable|date|after_or_equal:tanggal_dijadwalkan',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_dimulai',
            'status' => 'required|in:draft,dijadwalkan,selesai',
            'catatan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($stockOpnameSession, $validated) {
                $stockOpnameSession->update($validated);
            });

            return redirect(routeForRole('opname', 'index'))
                ->with('success', 'Sesi stock opname berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui sesi: '.$e->getMessage());
        }
    }

    public function destroy(StockOpnameSession $stockOpnameSession)
    {
        try {
            DB::transaction(function () use ($stockOpnameSession) {
                $stockOpnameSession->details()->delete();
                $stockOpnameSession->delete();
            });

            return redirect(routeForRole('opname', 'index'))
                ->with('success', 'Sesi stock opname berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect(routeForRole('opname', 'index'))
                ->with('error', 'Gagal menghapus sesi stock opname: '.$e->getMessage());
        }
    }

    public function start(Request $request, StockOpnameSession $opname)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string',
        ]);

        if ($opname->status !== 'draft') {
            return back()->with('error', 'Sesi hanya bisa dimulai jika statusnya draft.');
        }

        try {
            DB::transaction(function () use ($opname, $request) {
                $opname->update([
                    'status' => 'dijadwalkan',
                    'catatan' => $request->catatan ?? 'Stock opname untuk '.$opname->departement->nama,
                ]);
            });

            return back()->with('success', 'Sesi stock opname berhasil dimulai.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memulai sesi: '.$e->getMessage());
        }
    }

    public function complete(StockOpnameSession $stockOpnameSession)
    {
        if ($stockOpnameSession->status !== 'ongoing') {
            return back()->with('error', 'Sesi hanya bisa diselesaikan jika statusnya ongoing.');
        }

        try {
            DB::transaction(function () use ($stockOpnameSession) {
                $stockOpnameSession->update([
                    'status' => 'completed',
                    'tanggal_selesai' => now(),
                ]);
            });

            return back()->with('success', 'Sesi stock opname berhasil diselesaikan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyelesaikan sesi: '.$e->getMessage());
        }
    }

    public function cancel(StockOpnameSession $opname)
    {
        try {
            DB::transaction(function () use ($opname) {
                if ($opname->status === 'draft') {
                    $opname->details()->delete();
                    $opname->delete();
                } elseif ($opname->status === 'dijadwalkan') {
                    $opname->update(['status' => 'cancelled']);

                    // return back()->with('success', 'Sesi stock opname berhasil dibatalkan.');
                    // routeForRole('opname', 'show', $session->id) }}
                    return redirect(routeForRole('opname', 'show', $opname->id))
                        ->with('success', 'Sesi stock opname berhasil dibatalkan');
                }
            });

            return redirect(routeForRole('opname', 'index'))
                ->with('success', 'Sesi stock opname berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan sesi: '.$e->getMessage());
        }
    }
}
