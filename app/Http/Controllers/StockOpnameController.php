<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StockOpnameDetail;
use App\Models\Asset;
use App\Models\Departement;
use App\Models\CategoryGroup;
use App\Models\User;
use App\Models\StockOpnameSession;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $institutionId = $user->employee->institution_id;

        $departements = Departement::where('instansi_id', $institutionId)->get();

        $sessions = StockOpnameSession::with(['scheduler', 'details'])
            ->latest()
            ->paginate(10);

        return view('opname.institution.index', compact('sessions', 'departements'));
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
            'departement_id' => 'required|exists:departements,id',
            'jenis_aset' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $existingSession = StockOpnameSession::where('departement_id', $request->departement_id)
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
        $departement = Departement::find($request->departement_id);

        if ($departement->kepala == null) {
            return back()->with('info', 'Departemen ini belum memiliki kepala.')->withInput();
        }
        if ($departement->kepala->user == null) {
            return back()->with('info', 'Kepala Departemen ini belum memiliki akun.')->withInput();
        }

        try {
            DB::transaction(function () use ($request, $departement, $user) {
                // 1. Buat sesi opname
                $session = StockOpnameSession::create([
                    'nama' => 'Opname ' . $departement->nama . ' - ' . $request->jenis_aset . ' (' . $request->tanggal_dijadwalkan . ')',
                    'scheduled_by' => $user->id,
                    'departement_id' => $request->departement_id,
                    'tanggal_dijadwalkan' => $request->tanggal_dijadwalkan,
                    'tanggal_deadline' => $request->tanggal_deadline,
                    'status' => 'draft',
                    'catatan' => $request->catatan ?? '',
                ]);

                // 2. Ambil semua aset yang cocok
                $assetsToOpname = Asset::where('departement_id', $request->departement_id)
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
                        'jumlah_fisik' => 0,
                        'status_lama' => $asset->status,
                        'status_fisik' => $asset->status,
                        'checked_by' => $departement->kepala->user->id,
                    ]);
                }
            });

            return redirect(routeForRole('opname', 'index'))
                ->with('success', 'Jadwal stock opname berhasil dibuat.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal membuat sesi stock opname: ' . $e->getMessage())
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
            return back()->with('error', 'Gagal memperbarui sesi: ' . $e->getMessage());
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
                ->with('error', 'Gagal menghapus sesi stock opname: ' . $e->getMessage());
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
                    'catatan' => $request->catatan ?? 'Stock opname untuk ' . $opname->departement->nama,
                ]);
            });

            return back()->with('success', 'Sesi stock opname berhasil dimulai.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memulai sesi: ' . $e->getMessage());
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
            return back()->with('error', 'Gagal menyelesaikan sesi: ' . $e->getMessage());
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
                }
            });

            return back()->with('success', 'Sesi stock opname berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan sesi: ' . $e->getMessage());
        }
    }
}
