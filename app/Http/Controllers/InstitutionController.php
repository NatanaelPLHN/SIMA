<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansis = Institution::latest()->paginate(10);
        return view('institution.index', compact('instansis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('institution.create_institution');
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
            'alias' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama instansi wajib diisi.',
            'pemerintah.required' => 'Nama pemerintah wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        Institution::create($validated);

        return redirect()->route('superadmin.institution.index')->with('success', 'Instansi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        return view('institution.show', compact('institution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        return view('institution.edit_institution', compact('institution'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
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
        $original = $institution->replicate();
        $institution->fill($validated);
        if (!$institution->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data instansi.');
        }

    $institution->save();
    $institution->update($validated);

        return redirect()->route('superadmin.institution.index')->with('success', 'Instansi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        try {
            $institution->delete();
            return redirect()->route('superadmin.institution.index')->with('success', 'Instansi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.institution.index')->with('error', 'Gagal menghapus instansi. Instansi masih digunakan dalam data lain.');
        }
    }
}