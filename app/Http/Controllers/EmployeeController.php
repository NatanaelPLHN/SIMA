<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Departement;
use Illuminate\Http\Request;

use App\Models\Institution;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Employee::class, 'employee');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $employees = Employee::with(['department', 'user'])->paginate(10);
        // return view('employee.index', compact('employees'));
        $user = auth()->user();
        // Logika untuk memfilter data berdasarkan peran adalah logika bisnis,
        // jadi tetap di controller. Ini sudah benar.
        $query = Employee::with(['department.institution', 'user']);

        if ($user->role == 'admin') {
            $query->whereHas('department.institution', function ($q) use ($user) {
                $q->where('id', $user->employee?->institution->id);
            });
        } elseif ($user->role == 'subadmin') {
            // Subadmin hanya boleh lihat employee di departemennya
            $query->where('department_id', $user->employee->department_id);
        }

        $employees = $query->paginate(10);
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $institutions = Institution::all();
        // $departements = Departement::all();
        // return view('employee.create_employee', compact('institutions', 'departements'));
        $user = auth()->user();
        $institutions = collect();
        $departements = collect();

        if ($user->role == 'superadmin') {
            $institutions = Institution::all();
            $departements = Departement::all();
        } elseif ($user->role == 'admin') {
            // user()->employee?->institution->id
            $institutions = Institution::where('id', $user->employee?->institution->id)->get();
            $departements = Departement::where('instansi_id', $user->employee?->institution->id)->get();
        }

        return view('employee.create_employee', compact('institutions', 'departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'institution_id' => 'nullable|exists:institutions,id',
            'department_id' => 'nullable|exists:departements,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            // 'institution_id.exists' => 'Institusi tidak ditemukan.',
            // 'department_id.exists' => 'Bidang tidak ditemukan.',
        ]);
        // Logika bisnis dan pengisian data otomatis berdasarkan peran
        // employee?->institution->id;
        if ($user->role == 'superadmin') {
            if (empty($validated['institution_id'])) {
                return back()->withErrors(['institution_id' => 'Institusi dan Bidang wajib dipilih.'])->withInput();
            }
        }
        elseif ($user->role =='admin') {
            $validated['institution_id'] = $user->employee?->institution->id;
            if (empty($validated['department_id'])) {
                return back()->withErrors(['department_id' => 'Bidang wajib dipilih.'])->withInput();
            }
            $department = Departement::find($validated['department_id']);
            if (!$department || $department->instansi_id != $user->employee?->institution->id) {
                return back()->withErrors(['department_id' => 'Anda hanya dapat memilih bidang dari institusi Anda.'])->withInput();
            }
        } elseif ($user->role == 'subadmin') {
            $validated['institution_id'] = $user->employee?->institution->id;
            $validated['department_id'] = $user->employee->department_id;
        }

        Employee::create($validated);

        return redirect(routeForRole('employee', 'index'))->with('success', 'Karyawan berhasil ditambahkan.');
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
        // $employee->load('department.institution');
        // $institutions = Institution::all();
        // $departements = Departement::all();
        // return view('employee.edit_employee', compact('employee', 'institutions', 'departements'));
        $employee->load('department.institution');
      $user = auth()->user();
      $institutions = collect();
      $departements = collect();

      if ($user->role == 'superadmin') {
          $institutions = Institution::all();
          $departements = Departement::all();
      } elseif ($user->role == 'admin') {
          $institutionId = $user->employee?->institution->id;
          $institutions = Institution::where('id', $institutionId)->get();
          $departements = Departement::where('instansi_id', $institutionId)->get();
      }
      // Untuk subadmin, tidak perlu mengambil data apa pun karena mereka tidak bisa mengubah departemen.
      // Form bisa dibuat read-only untuk mereka.

      return view('employee.edit_employee', compact('employee', 'institutions', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $oldDepartmentId = $employee->department_id;
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip,' . $employee->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'institution_id' => 'nullable|exists:institutions,id',
            'department_id' => 'nullable|exists:departements,id',
        ], [
            'nip.unique' => 'NIP sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'institution_id.exists' => 'Institusi tidak ditemukan.',
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

        return redirect(routeForRole('employee', 'index'))->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return redirect(routeForRole('employee', 'index'))->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect(routeForRole('employee', 'index'))->with('error', 'Gagal menghapus karyawan. Karyawan masih memiliki data peminjaman.');
        }
    }
}
