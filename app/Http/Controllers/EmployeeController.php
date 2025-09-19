<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::paginate(10);
        return view('employee.employee', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create_employee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit_employee', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip,' . $employee->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'Gagal menghapus karyawan. Karyawan masih memiliki data peminjaman.');
        }
    }
}