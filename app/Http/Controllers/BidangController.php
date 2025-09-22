<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Instansi;
use App\Models\Employee;
use Illuminate\Http\Request;
class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bidangs = Bidang::with(['instansi', 'kepala'])->paginate(10);
        return view('bidang.bidang', compact('bidangs'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instansis = Instansi::all();
        $employees = Employee::all();
        return view('bidang.create_bidang', compact('instansis', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_bidang' => 'nullable|exists:employees,id',
            'lokasi' => 'nullable|string|max:255',
            'instansi_id' => 'required|exists:instansi,id',
        ], [
            'nama.required' => 'Nama bidang wajib diisi.',
            'instansi_id.required' => 'Instansi wajib dipilih.',
            'instansi_id.exists' => 'Instansi tidak ditemukan.',
            'kepala_bidang.exists' => 'Kepala bidang tidak ditemukan.',
        ]);

        Bidang::create($validated);

        return redirect()->route('superadmin.bidang.index')->with('success', 'Bidang berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        return view('bidang.show', compact('bidang'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        $instansis = Instansi::all();
        $employees = Employee::all();
        return view('bidang.edit_bidang', compact('bidang', 'instansis', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_bidang' => 'nullable|exists:employees,id',
            'lokasi' => 'nullable|string|max:255',
            'instansi_id' => 'required|exists:instansi,id',
        ], [
            'nama.required' => 'Nama bidang wajib diisi.',
            'instansi_id.required' => 'Instansi wajib dipilih.',
            'instansi_id.exists' => 'Instansi tidak ditemukan.',
            'kepala_bidang.exists' => 'Kepala bidang tidak ditemukan.',
        ]);

        $bidang->update($validated);

        return redirect()->route('superadmin.bidang.index')->with('success', 'Bidang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang)
    {
        try {
            $bidang->delete();
            return redirect()->route('superadmin.bidang.index')->with('success', 'Bidang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.bidang.index')->with('error', 'Gagal menghapus bidang. Bidang masih digunakan dalam data lain.');
        }
    }
}
