<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Departement;
use Illuminate\Http\Request;

use App\Models\Institution;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'nama');
        // default sort by 'nama' 
        $direction = $request->get('direction', 'asc');

        // Daftar kolom yang diizinkan untuk sorting (aman dari SQL injection)
        $allowedSorts = ['nip', 'nama', 'alamat', 'telepon', 'email', 'bidang'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'nama';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query = Employee::with(['department', 'user']);

        // Filter pencarian
        $query->when($search, function ($q) use ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u->where('email', 'like', "%{$search}%"))
                    ->orWhereHas('department', fn($d) => $d->where('nama', 'like', "%{$search}%"));
            });
        });

        // Sorting
        if ($sort === 'email') {
            // Sorting berdasarkan relasi user.email → butuh join
            $query->join('users', 'employees.id', '=', 'users.karyawan_id')
                ->orderBy('users.email', $direction)
                ->select('employees.*');
        } elseif ($sort === 'bidang') {
            // Sorting berdasarkan relasi department.nama
            $query->join('departements', 'employees.department_id', '=', 'departements.id')
                ->orderBy('departements.nama', $direction)
                ->select('employees.*');
        } else {
            // Kolom langsung di tabel employees
            $query->orderBy($sort, $direction);
        }

        // Pagination + append semua query string (search, sort, direction)
        $employees = $query->paginate(10)->appends([
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);

        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutions = Institution::all();
        $departements = Departement::all();
        return view('employee.create_employee', compact('institutions', 'departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departements,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'department_id.exists' => 'Bidang tidak ditemukan.',
        ]);

        Employee::create($validated);

        return redirect()->route('superadmin.employee.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load('department'); // Tambahkan ini
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $employee->load('department.institution');
        $institutions = Institution::all();
        $departements = Departement::all();
        return view('employee.edit_employee', compact('employee', 'institutions', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {$oldDepartmentId = $employee->department_id;
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip,' . $employee->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departements,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'department_id.exists' => 'Bidang tidak ditemukan.',
        ]);
        // Cek apakah departemen karyawan berubah
      // dan apakah karyawan tersebut adalah kepala di departemen lamanya.
      if ($oldDepartmentId && $oldDepartmentId != $request->department_id) {
        $oldDepartment = Departement::find($oldDepartmentId);

        // Jika departemen lama ada dan ID karyawan sama dengan kepala idang
        if ($oldDepartment && $oldDepartment->kepala_bidang_id == $employee->id) {
            // Hapus jabatan kepala bidang dari departemen lama
            $oldDepartment->kepala_bidang_id = null;
            $oldDepartment->save();
        }
    }
        $original = $employee->replicate();
        $employee->fill($validated);
        if (!$employee->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data employee.');
        }
        $employee->save();
        $employee->update($validated);

        return redirect()->route('superadmin.employee.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('superadmin.employee.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.employee.index')->with('error', 'Gagal menghapus karyawan. Karyawan masih memiliki data peminjaman.');
        }
    }
}
