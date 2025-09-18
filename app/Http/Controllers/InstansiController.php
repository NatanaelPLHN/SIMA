<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansis = Instansi::latest()->paginate(10);
        return view('superadmin.instansi', compact('instansis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.Forms.create_instansi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'pemerintah' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama instansi wajib diisi.',
            'pemerintah.required' => 'Nama pemerintah wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        Instansi::create($validated);

        return redirect()->route('superadmin.instansi.index')->with('success', 'Instansi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instansi $instansi)
    {
        return view('instansi.show', compact('instansi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instansi $instansi)
    {
        return view('superadmin.Forms.edit_instansi', compact('instansi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instansi $instansi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'pemerintah' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama instansi wajib diisi.',
            'pemerintah.required' => 'Nama pemerintah wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $instansi->update($validated);

        return redirect()->route('superadmin.instansi.index')->with('success', 'Instansi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instansi $instansi)
    {
        try {
            $instansi->delete();
            return redirect()->route('superadmin.instansi.index')->with('success', 'Instansi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.instansi.index')->with('error', 'Gagal menghapus instansi. Instansi masih digunakan dalam data lain.');
        }
    }
}