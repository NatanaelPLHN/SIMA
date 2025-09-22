<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $employees = Employee::paginate(10);
        // return view('employee.employee', compact('employees'));
        $employees = Employee::with('bidang')->paginate(10);
        return view('employee.employee', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bidangs = Bidang::all();
        return view('employee.create_employee', compact('bidangs'));
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
            'email' => 'required|email|unique:karyawan,email',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:bidang,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'department_id.exists' => 'Bidang tidak ditemukan.',
        ]);

        Karyawan::create($validated);

        return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $employee)
    {
        $employee->load('bidang'); // Tambahkan ini
        return view('employees.show', compact('employee'));
        // return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $employee)
    {
        $employee->load('bidang'); // Tambahkan ini
        $bidangs = Bidang::all(); // Tambahkan ini
        return view('employee.edit_employee', compact('employee', 'bidangs'));

        // return view('employee.edit_employee', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $employee)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:karyawan,nip,' . $employee->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email,' . $employee->id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:bidang,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'department_id.exists' => 'Bidang tidak ditemukan.',
        ]);
         $original = $employee->replicate();
          $employee->fill($validated);
        if (!$employee->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data employee.');
        }
        $employee->save();
        $employee->update($validated);

        return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.karyawan.index')->with('error', 'Gagal menghapus karyawan. Karyawan masih memiliki data peminjaman.');
        }
    }
}
