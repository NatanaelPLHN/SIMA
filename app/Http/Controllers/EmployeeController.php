<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Departement;
use App\Models\Institution;
use App\Models\AssetUsage;
use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Employee::class, 'employee');
    }

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

        if ($user->role == 'superadmin') {
            $query->whereNull('department_id');
        } elseif ($user->role == 'admin') {
            $query->whereHas('institution', function ($q) use ($user) {
                $q->where('id', $user->employee?->institution->id);
            });
            $query->where('id', '!=', $user->employee?->id);
        } elseif ($user->role == 'subadmin') {
            $query->where('department_id', $user->employee->department_id);
            $query->where('id', '!=', $user->employee?->id);
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

        return view('employee.index', compact('employees', 'user'));
    }

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
        ],[
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'telepon.string' => 'Telepon harus berupa teks.',
            'telepon.max' => 'Telepon maksimal 20 karakter.',
            'institution_id.exists' => 'Institusi tidak valid.',
            'department_id.exists' => 'Bidang tidak valid.',
        ]);

        // Business rules per role
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

        // ✅ Use DB transaction to ensure atomicity
        try {
            DB::transaction(function () use ($validated) {
                Employee::create($validated);
            });

            return redirect(routeForRole('employee', 'index'))
                ->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Employee $employee)
    {
        $employee->load('department'); // Tambahkan ini
        return view('employees.show', compact('employee'));
    }

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
        ]);
        // Cek apakah departemen diubah dan apakah ada aset yang masih digunakan
        if ($request->department_id != $oldDepartmentId) {
            $activeUsage = AssetUsage::where('used_by', $employee->id)
                ->where('status', 'dipakai')
                ->exists();

            if ($activeUsage) {
                return back()->with('error', 'Tidak dapat memindahkan karyawan. Pastikan semua aset yang digunakan telah dikembalikan.')->withInput();
            }
        }

        try {
            DB::transaction(function () use ($employee, $validated, $oldDepartmentId, $request) {
                // If department changed, and employee was head of old one — remove them
                if ($oldDepartmentId && $oldDepartmentId != $request->department_id) {
                    $oldDepartment = Departement::find($oldDepartmentId);
                    if ($oldDepartment && $oldDepartment->kepala_bidang_id == $employee->id) {
                        $oldDepartment->update(['kepala_bidang_id' => null]);
                    }
                }

                $employee->fill($validated);
                if ($employee->isDirty()) {
                    $employee->save();
                }
            });

            return redirect(routeForRole('employee', 'index'))
                ->with('success', 'Karyawan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Employee $employee)
    {
        // Cek apakah ada aset yang masih digunakan oleh karyawan ini
        $activeUsage = AssetUsage::where('used_by', $employee->id)
            ->where('status', 'dipakai')
            ->exists();

        if ($activeUsage) {
            return redirect(routeForRole('employee', 'index'))
                ->with('error', 'Tidak dapat menghapus karyawan. Pastikan semua aset yang digunakan telah dikembalikan.');
        }
        try {
            DB::transaction(function () use ($employee) {
                // Future-proof: if we need to unlink or cascade other data later
                $employee->delete();
            });

            return redirect(routeForRole('employee', 'index'))
                ->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect(routeForRole('employee', 'index'))
                ->with('error', 'Gagal menghapus karyawan. ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Excel::import(new UsersImport, 'users.xlsx');
        Excel::import(new EmployeesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data pegawai berhasil di import!');
    }

    public function export()
    {
        // authorize policy
        $this->authorize('viewAny', Employee::class);

        $user = auth()->user();

        if ($user->role === 'superadmin') {
            $employees = Employee::all();
        } elseif ($user->role === 'admin') {
            $employees = Employee::whereHas('department.institution', function ($query) use ($user) {
                $query->where('id', $user->employee->institution_id);
            })->get();
        } elseif ($user->role === 'subadmin') {
            $employees = Employee::where('department_id', $user->employee->department_id)->get();
        } else {
            $employees = Employee::where('id', $user->employee_id)->get();
        }

        return Excel::download(new EmployeesExport($employees), 'pegawai.xlsx');
    }
}
