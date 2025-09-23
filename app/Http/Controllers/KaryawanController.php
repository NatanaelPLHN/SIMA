<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Bidang;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $employees = Employee::paginate(10);
        $employees = Karyawan::with('bidang')->paginate(10);
        return view('karyawan.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bidangs = Bidang::all();
        return view('karyawan.create_karyawan', compact('bidangs'));
        // return view('employee.create_employee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:karyawan,nip',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:bidang,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'department_id.exists' => 'Bidang tidak ditemukan.',
        ]);

        Karyawan::create($validated);

        return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        $karyawan->load('bidang'); // Tambahkan ini
        return view('karyawan.show', compact('karyawan'));
        // return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('bidang'); // Tambahkan ini
        $bidangs = Bidang::all(); // Tambahkan ini
        return view('karyawan.edit_karyawan', compact('karyawan', 'bidangs'));

        // return view('employee.edit_employee', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:karyawan,nip,' . $karyawan->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:bidang,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'department_id.exists' => 'Bidang tidak ditemukan.',
        ]);
         $original = $karyawan->replicate();
          $karyawan->fill($validated);
        if (!$karyawan->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data employee.');
        }
        $karyawan->save();
        $karyawan->update($validated);

        return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        try {
            $karyawan->delete();
            return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.karyawan.index')->with('error', 'Gagal menghapus karyawan. Karyawan masih memiliki data peminjaman.');
        }
    }
}
