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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = Auth::user();
        $user = auth()->user();
        // Pastikan user memiliki relasi employee dan departemen untuk mendapatkan institusi
        // if (!$user->employee?->department?->institution) {
        //     return redirect()->route('superadmin.opname.index')->with('error', 'Informasi institusi tidak ditemukan untuk akun Anda.');
        // }
        $institutionId = $user->employee?->department?->institution?->id;

        // Ambil departemen yang hanya berada di institusi superadmin
        $departements = Departement::where('instansi_id', $institutionId)->get();

        // Ambil semua grup kategori
        $categoryGroups = CategoryGroup::all();

        //   return view('opname.institution.create', compact('departements', 'categoryGroups'));

        $sessions = StockOpnameSession::with(['scheduler','details'])
            ->latest()
            ->paginate(10);
        return view('opname.institution.index', compact('sessions', 'departements', 'categoryGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd("berhasil");
        $request->validate([
            'tanggal_dijadwalkan' => 'required|date',
            'departement_id' => 'required|exists:departements,id',
            'category_group_id' => 'required|exists:category_groups,id',
            'catatan' => 'nullable|string',
        ]);
        $user = auth()->user();
        // dd($user);
        $departement = Departement::find($request->departement_id);
        $categoryGroup = CategoryGroup::find($request->category_group_id);
        // dd($session);

        // 1. Buat Sesi Stock Opname baru
        $session = StockOpnameSession::create([
            'nama' => 'Opname ' . $departement->nama . ' - ' . $categoryGroup->nama . ' (' . $request->tanggal_dijadwalkan . ')',
            'scheduled_by' => $user->id,
            'tanggal_dijadwalkan' => $request->tanggal_dijadwalkan,
            'status' => 'draft',
            'catatan' => '',
               ]);
        // Jika sesi gagal dibuat, hentikan proses.
        if (!$session) {
            return back()->with('error', 'Gagal membuat sesi stock opname.')->withInput();
        }
        // 3. Cari semua Aset yang cocok dengan kriteria
        $assetsToOpname = Asset::where('departement_id', $request->departement_id)
            ->whereHas('category', function ($query) use ($request) {
                $query->where('category_group_id', $request->category_group_id);
            })
            ->get();


            if ($assetsToOpname->isEmpty()) {
            $session->delete(); // Hapus sesi yang kosong
            return back()->with('info', 'Tidak ada aset yang ditemukan untuk departemen dan grup kategori yang dipilih.')->withInput();
        }


        foreach ($assetsToOpname as $asset) {
            // Di sini kita membuat baris baru di tabel stock_opname_details
            StockOpnameDetail::create([
                'stock_opname_id' => $session->id, // Menghubungkan detail ini ke sesi yang baru dibuat
                'aset_id' => $asset->id,
                'jumlah_sistem' => $asset->jumlah,
                'jumlah_fisik' => 0, // Default 0, akan diisi saat pengecekan
                'status_lama' => $asset->status, // Status default
                'status_fisik' => 'tersedia', // Status default
                'checked_by' => $departement->kepala->id, // Penanggung jawab awal
            ]);
        }

        return redirect()->route('superadmin.opname.index')->with('success', 'Jadwal stock opname berhasil dibuat.');

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


    /**
     * Update the specified resource in storage.
     */
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
        ], [
            'nama.required' => 'Nama sesi wajib diisi.',
            'scheduled_by.required' => 'User penjadwal wajib dipilih.',
            'scheduled_by.exists' => 'User penjadwal tidak ditemukan.',
            'status.in' => 'Status tidak valid.',
        ]);

        $stockOpnameSession->update($validated);

        return redirect()->route('superadmin.stock-opname-sessions.index')
            ->with('success', 'Sesi stock opname berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockOpnameSession $stockOpnameSession)
    {
        try {
            $stockOpnameSession->delete();
            return redirect()->route('superadmin.stock-opname-sessions.index')
                ->with('success', 'Sesi stock opname berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.stock-opname-sessions.index')
                ->with('error', 'Gagal menghapus sesi stock opname.');
        }
    }
    public function start(Request $request, StockOpnameSession $opname)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string',

        ]);
        if ($opname->status !== 'draft') {
            return redirect()->back()
                ->with('error', 'Sesi hanya bisa dimulai jika statusnya draft.');
        }


        $opname->update([
            'status' => 'dijadwalkan',
            'catatan' => $request->catatan ?? 'Stock opname untuk ' . 'nama departeent',

        ]);

        return redirect()->back()->with('success', 'Sesi stock opname berhasil dimulai.');
    }
    public function complete(StockOpnameSession $stockOpnameSession)
    {
        if ($stockOpnameSession->status !== 'ongoing') {
            return redirect()->back()
                ->with('error', 'Sesi hanya bisa diselesaikan jika statusnya ongoing.');
        }

        $stockOpnameSession->update([
            'status' => 'completed',
            'tanggal_selesai' => now(),
        ]);

        return redirect()->back()->with('success', 'Sesi stock opname berhasil diselesaikan.');
    }
    public function cancel(StockOpnameSession $stockOpnameSession)
    {
        if ($stockOpnameSession->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Sesi yang sudah selesai tidak bisa dibatalkan.');
        }

        $stockOpnameSession->update([
            'status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Sesi stock opname berhasil dibatalkan.');
    }
}
