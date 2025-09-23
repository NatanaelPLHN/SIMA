<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Instansi;
// use App\Models\Karyawan;
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
        // Untuk create, tidak ada employee karena bidang belum ada
        $employees = collect();
        return view('bidang.create_bidang', compact('instansis', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_bidang_id' => 'nullable|exists:employees,id',
            'lokasi' => 'nullable|string|max:255',
            'instansi_id' => 'required|exists:instansi,id',
        ], [
            'nama.required' => 'Nama bidang wajib diisi.',
            'instansi_id.required' => 'Instansi wajib dipilih.',
            'instansi_id.exists' => 'Instansi tidak ditemukan.',
            'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan.',
        ]);

        // Validasi: kepala_bidang harus null saat create karena bidang belum ada
        if ($request->kepala_bidang) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['kepala_bidang' => 'Kepala bidang dapat dipilih setelah bidang dibuat.']);
        }
        // Validasi custom: nama dan instansi harus unique bersama
        $existing = Bidang::where('nama', $request->nama)
            ->where('instansi_id', $request->instansi_id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama bidang sudah ada untuk instansi ini.']);
        }

        $bidang = Bidang::create($validated);

        return redirect()->route('superadmin.bidang.index')->with('success', 'Bidang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        $bidang->load(['instansi', 'kepala', 'employees']);
        return view('bidang.show', compact('bidang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        $instansis = Instansi::all();
        // Hanya tampilkan employee yang ada di bidang ini
        $employees = Employee::where('department_id', $bidang->id)->get();
        return view('bidang.edit_bidang', compact('bidang', 'instansis', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_bidang_id' => 'nullable|exists:employees,id',
            'lokasi' => 'nullable|string|max:255',
            'instansi_id' => 'required|exists:instansi,id',
        ], [
            'nama.required' => 'Nama bidang wajib diisi.',
            'instansi_id.required' => 'Instansi wajib dipilih.',
            'instansi_id.exists' => 'Instansi tidak ditemukan.',
            'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan.',
        ]);

        // Validasi tambahan: pastikan kepala_bidang adalah anggota bidang ini
        if ($request->kepala_bidang) {
            $employee = Employee::find($request->kepala_bidang);
            if ($employee && $employee->department_id != $bidang->id) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['kepala_bidang' => 'Kepala bidang harus merupakan anggota bidang ini.']);
            }
        }
        // Validasi custom: nama dan instansi harus unique bersama
        $existing = Bidang::where('nama', $request->nama)
            ->where('instansi_id', $request->instansi_id)
            ->where('id', '!=', $bidang->id) // Kecualikan record yang sedang diupdate
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama bidang sudah ada untuk instansi ini.']);
        }
        $original = $bidang->replicate();
        $bidang->fill($validated);
        if (!$bidang->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data bidang.');
        }
        $bidang->save();
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
