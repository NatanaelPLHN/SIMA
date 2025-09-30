<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StockOpnameDetail;
use App\Models\User;
use App\Models\StockOpnameSession;


class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = StockOpnameSession::with('scheduler')
            ->latest()
            ->paginate(10);
        return view('opname.institution.index', compact('sessions'));
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
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'scheduled_by' => 'required|exists:users,id',
            'tanggal_dijadwalkan' => 'required|date|after_or_equal:today',
            'tanggal_dimulai' => 'nullable|date|after_or_equal:tanggal_dijadwalkan',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_dimulai',
            'status' => 'required|in:draft,dijadwalkan,selesai',
            'catatan' => 'nullable|string',
        ], [
            'nama.required' => 'Nama sesi wajib diisi.',
            'scheduled_by.required' => 'User penjadwal wajib dipilih.',
            'scheduled_by.exists' => 'User penjadwal tidak ditemukan.',
            'tanggal_dijadwalkan.required' => 'Tanggal dijadwalkan wajib diisi.',
            'tanggal_dijadwalkan.after_or_equal' => 'Tanggal dijadwalkan harus hari ini atau setelahnya.',
            'status.in' => 'Status tidak valid.',
        ]);
        StockOpnameSession::create($validated);

        return redirect()->route('opname.index')
            ->with('success', 'Sesi stock opname berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockOpnameSession $stockOpnameSession)
    {
        $stockOpnameSession->load(['scheduler', 'details']);
        return view('stock-opname-sessions.show', compact('stockOpnameSession'));
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
    public function start(StockOpnameSession $stockOpnameSession)
    {
        if ($stockOpnameSession->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Sesi hanya bisa dimulai jika statusnya pending.');
        }

        $stockOpnameSession->update([
            'status' => 'ongoing',
            'tanggal_dimulai' => now(),
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
