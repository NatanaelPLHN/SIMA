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
    public function index(Request $request)
{
    $user = auth()->user();

    // Ambil parameter query
    $search = $request->get('search');
    $sort = $request->get('sort', 'nama');
    $direction = $request->get('direction', 'asc');

    // Validasi kolom sorting yang diizinkan
    $allowedSorts = ['nip', 'nama', 'alamat', 'telepon', 'email', 'bidang'];
    if (!in_array($sort, $allowedSorts)) {
        $sort = 'nama';
    }
    if (!in_array(strtolower($direction), ['asc', 'desc'])) {
        $direction = 'asc';
    }

    // Mulai query dengan relasi
    $query = Employee::with(['department', 'institution', 'user']);

    // === Filter berdasarkan role ===
    if ($user->role === 'superadmin') {
        $query->whereNull('department_id');
    } elseif ($user->role === 'admin') {
        $institutionId = $user->employee?->institution_id;
        if ($institutionId) {
            $query->whereHas('institution', fn($q) => $q->where('id', $institutionId));
        } else {
            $query->whereRaw('1 = 0'); // Tidak ada data
        }
    } elseif ($user->role === 'subadmin') {
        $departmentId = $user->employee?->department_id;
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        } else {
            $query->whereRaw('1 = 0');
        }
    }

    // === Pencarian ===
    $query->when($search, function ($q) use ($search) {
        $q->where(function ($sub) use ($search) {
            $sub->where('nama', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('telepon', 'like', "%{$search}%")
                ->orWhereHas('user', fn($u) => $u->where('email', 'like', "%{$search}%"))
                ->orWhereHas('department', fn($d) => $d->where('nama', 'like', "%{$search}%"))
                ->orWhereHas('institution', fn($i) => $i->where('nama', 'like', "%{$search}%"));
        });
    });

    // === Sorting ===
    if ($sort === 'email') {
        $query->join('users', 'employees.id', '=', 'users.karyawan_id')
              ->orderBy('users.email', $direction)
              ->select('employees.*')
              ->distinct();
    } elseif ($sort === 'bidang') {
        // ✅ Perbaikan: gunakan 'departments' (bukan 'departements')
        $query->join('departments', 'employees.department_id', '=', 'departments.id')
              ->orderBy('departments.nama', $direction)
              ->select('employees.*')
              ->distinct();
    } else {
        $query->orderBy($sort, $direction);
    }

    // Pagination dengan append query string
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
        $isInstitutionHead = false;

        return view('employee.create_employee', compact('institutions', 'departements', 'isInstitutionHead'));
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
        } elseif ($user->role == 'admin') {
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
        $isInstitutionHead = Institution::where('kepala_instansi_id', $employee->id)->exists();

        return view('employee.edit_employee', compact('employee', 'institutions', 'departements', 'isInstitutionHead'));
        // return view('employee.edit_employee', compact('employee', 'institutions', 'departements'));
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
