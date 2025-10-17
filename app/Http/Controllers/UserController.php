<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Departement;
use App\Models\Employee;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $user = Auth::user();
        $query = User::query();

        if ($user->role === 'superadmin') {
            // $query->where('role', 'admin');
            $query->whereIn('role', ['admin', 'subadmin', 'user']);
        } elseif ($user->role === 'admin') {
            $query->where('role', 'subadmin')
                ->whereHas('employee.institution', function ($q) use ($user) {
                    $q->where('id', $user->employee->institution_id);
                });
        } elseif ($user->role === 'subadmin') {
            $query->where('role', 'user')
                ->whereHas('employee.department', function ($q) use ($user) {
                    $q->where('id', $user->employee->department_id);
                });
        } else {
            $query->whereRaw('1 = 0');
        }
        $users = $query->with('employee.institution', 'employee.department')->paginate(10);
        return view('user.index', compact('users'));
        // $users = $query->with('employee')->paginate(10);
        // return view('user.index', compact('users'));
    }

    // public function create()
    // {
    //     $login = Auth::user();
    //     $user_role = $login->role;

    //     $employees = collect();
    //     $creatable_role = '';

    //     $departments = Departement::whereDoesntHave('employees.user', function ($query) {
    //         $query->where('role', 'admin');
    //     })->get();

    //     if ($user_role === 'superadmin') {
    //         $creatable_role = 'admin';
    //         $kepalaInstansiIds = Institution::whereNotNull('kepala_instansi_id')->pluck('kepala_instansi_id');
    //         $employees = Employee::whereIn('id', $kepalaInstansiIds)
    //             ->whereDoesntHave('user')
    //             ->orderBy('nama')
    //             ->get();
    //     } elseif ($user_role === 'admin') {
    //         $creatable_role = 'subadmin';
    //         $kepalaDepartemenIds = Departement::where('instansi_id', $login->employee->institution_id)
    //             ->whereNotNull('kepala_bidang_id')
    //             ->pluck('kepala_bidang_id');
    //         $employees = Employee::whereIn('id', $kepalaDepartemenIds)
    //             ->whereDoesntHave('user')
    //             ->orderBy('nama')
    //             ->get();
    //     } elseif ($user_role === 'subadmin') {
    //         $creatable_role = 'user';
    //         $employees = Employee::where('department_id', $login->employee->department_id)
    //             ->whereDoesntHave('user')
    //             ->orderBy('nama')
    //             ->get();
    //     }

    //     return view('user.create_user', compact('creatable_role', 'employees', 'login', 'departments'));
    // }
    public function create()
    {
        $this->authorize('create', User::class);
        $authUser = Auth::user();
        $roles = [];

        if ($authUser->isSuperAdmin()) {
            $roles = ['admin' => 'Admin', 'subadmin' => 'Sub Admin', 'user' => 'User'];
        } elseif ($authUser->isAdmin()) {
            $roles = ['subadmin' => 'Sub Admin', 'user' => 'User'];
        } elseif ($authUser->isSubAdmin()) {
            $roles = ['user' => 'User'];
        }

        return view('user.create_user', compact('roles'));
    }
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6|confirmed',
    //         'karyawan_id' => 'required|exists:employees,id|unique:users,karyawan_id',
    //     ], [
    //         'email.unique' => 'Email sudah digunakan.',
    //         'email.required' => 'Email wajib diisi.',
    //         'karyawan_id.unique' => 'Karyawan ini sudah memiliki akun.',
    //     ]);

    //     $user = Auth::user();
    //     $user_role = $user->role;
    //     $new_role = '';
    //     $employee = Employee::find($validated['karyawan_id']);

    //     // Tentukan role baru & validasi tambahan
    //     if ($user_role === 'superadmin') {
    //         $new_role = 'admin';
    //         $isKepalaInstansi = Institution::where('kepala_instansi_id', $employee->id)->exists();
    //         if (! $isKepalaInstansi) {
    //             return back()->withInput()->withErrors(['karyawan_id' => 'Superadmin hanya bisa membuat akun untuk Kepala Instansi.']);
    //         }
    //     } elseif ($user_role === 'admin') {
    //         $new_role = 'subadmin';
    //         $isKepalaDepartemen = Departement::where('kepala_bidang_id', $employee->id)->exists();
    //         if (! $isKepalaDepartemen) {
    //             return back()->withInput()->withErrors(['karyawan_id' => 'Admin hanya bisa membuat akun untuk Kepala Departemen.']);
    //         }
    //     } elseif ($user_role === 'subadmin') {
    //         $new_role = 'user';
    //         if ($employee->department_id !== $user->employee->department_id) {
    //             return back()->withInput()->withErrors(['karyawan_id' => 'Subadmin hanya bisa membuat akun untuk karyawan di departemennya sendiri.']);
    //         }
    //     } else {
    //         return back()->with('error', 'Anda tidak memiliki izin untuk membuat pengguna.');
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $validated['password'] = Hash::make($validated['password']);
    //         $validated['role'] = $new_role;

    //         User::create($validated);

    //         DB::commit();

    //         return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil ditambahkan.');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();

    //         return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    //     }
    // }
    public function store(Request $request)
    {
        // (Method store tidak perlu diubah, validasinya sudah mencakup semua)
        $validated = $request->validate([
            // 'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:6|confirmed',
            // 'karyawan_id' => 'required|exists:employees,id|unique:users,karyawan_id',
            // 'role' => 'required|in:admin,subadmin,user',
            // 'institution_id' => 'required_if:role,admin,subadmin|exists:institutions,id',
            // 'department_id' => 'required_if:role,subadmin|exists:departements,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'karyawan_id' => 'required|exists:employees,id|unique:users,karyawan_id',
            'role' => 'required|in:admin,subadmin,user',
            'institution_id' => 'nullable|required_if:role,admin,subadmin|exists:institutions,id',
            'department_id' => 'nullable|required_if:role,subadmin|exists:departements,id',
        ], [
            'email.unique' => 'Email sudah digunakan.',
            'karyawan_id.unique' => 'Karyawan ini sudah memiliki akun.',
            'institution_id.required_if' => 'Instansi wajib dipilih untuk role ini.',
            'department_id.required_if' => 'Departemen wajib dipilih untuk role ini.',
        ]);

        // Validasi Aturan Bisnis
        if ($validated['role'] === 'admin') {
            $hasAdmin = User::where('role', 'admin')
                ->whereHas('employee', function ($q) use ($validated) {
                    $q->where('institution_id', $validated['institution_id']);
                })->exists();
            if ($hasAdmin) {
                return back()->withInput()->withErrors(['institution_id' => 'Instansi ini sudah memiliki Admin.']);
            }
        }

        if ($validated['role'] === 'subadmin') {
            $hasSubadmin = User::where('role', 'subadmin')
                ->whereHas('employee', function ($q) use ($validated) {
                    $q->where('department_id', $validated['department_id']);
                })->exists();
            if ($hasSubadmin) {
                return back()->withInput()->withErrors(['department_id' => 'Departemen ini sudah memiliki Sub Admin.']);
            }
        }

        try {
            DB::beginTransaction();

            User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'karyawan_id' => $validated['karyawan_id'],
                'role' => $validated['role'],
            ]);

            DB::commit();
            return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $user->load('employee');

        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $login = Auth::user();
        $user->load('employee');

        $query = Employee::query();

        $departments = Departement::whereDoesntHave('employees.user', function ($query) {
            $query->where('role', 'admin');
        })->get();
        // Query HANYA mengambil karyawan yang BELUM punya akun,
        // ATAU karyawan yang saat ini terhubung dengan akun INI.
        $query->where(function ($q) use ($user) {
            $q->whereDoesntHave('user')
                ->orWhere('id', $user->karyawan_id);
        });

        // Terapkan filter role (ini harus ditambahkan setelah filter user_id)
        if ($login->role === 'superadmin') {
            $query->where('institution_id', $user->employee->institution_id);
        } elseif ($login->role === 'admin') {
            $query->where('institution_id', $login->employee->institution_id)
                ->where('id', '!=', $login->employee->id);
        } elseif ($login->role === 'subadmin') {
            $query->where('department_id', $login->employee->department_id)
                ->where('id', '!=', $login->employee->id);
        }

        $employees = $query->orderBy('nama')->get();

        return view('user.edit_user', compact('user', 'employees', 'login', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
            'karyawan_id' => ['nullable', 'exists:employees,id', Rule::unique('users', 'karyawan_id')->ignore($user->id)],
        ], [
            'email.unique' => 'Email sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'karyawan_id.exists' => 'Karyawan tidak ditemukan.',
            'karyawan_id.unique' => 'Karyawan ini sudah memiliki akun.',
        ]);

        $original = $user->replicate();

        try {
            DB::beginTransaction();

            if (! empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->fill($validated);

            if (! $user->isDirty()) {
                DB::rollBack();

                return back()->with('info', 'Tidak ada perubahan pada data user.');
            }

            $user->update($validated);

            DB::commit();

            return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect(routeForRole('user', 'index'))->with('error', 'Gagal menghapus akun. Akun masih memiliki data peminjaman.');
        }
    }

    public function getDepartements($institutionId)
    {
        if (Auth::user()->role !== 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $departements = Departement::where('instansi_id', $institutionId)
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($departements);
    }

    public function getEmployees($departmentId)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $department = Departement::find($departmentId);
            if (! $department || $department->instansi_id != $user->employee?->institution_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $employees = Employee::where('department_id', $departmentId)
            ->whereDoesntHave('user')
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($employees);
    }

    public function getEmployeesByDepartment($departmentId)
    {
        $employees = Employee::where('department_id', $departmentId)
            ->whereDoesntHave('user') // hanya karyawan tanpa akun
            ->get(['id', 'nama']);

        return response()->json($employees);
    }

    /**
     * Helper: Return consistent JSON or redirect error responses
     */
    private function errorResponse(Request $request, array $errors)
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => 'error', 'errors' => $errors], 422);
        }

        return back()->withInput()->withErrors($errors);
    }

    private function infoResponse(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => 'info', 'message' => $message]);
        }

        return back()->with('info', $message);
    }

    public function export()
    {
        $this->authorize('viewAny', User::class);

        $authUser = auth()->user();

        if ($authUser->role === 'superadmin') {
            // Superadmin can export only admin users
            $users = User::where('role', 'admin')->get();
        } elseif ($authUser->role === 'admin') {
            // Admin can export only subadmin users
            $users = User::where('role', 'subadmin')->get();
        } elseif ($authUser->role === 'subadmin') {
            // Subadmin can export only normal users
            $users = User::where('role', 'user')->get();
        } else {
            abort(403, 'You are not authorized to export user data.');
        }

        return Excel::download(new UsersExport($users), 'akun pegawai.xlsx');
    }
    // public function getInstitutionsForRole(Request $request)
    // {
    //     $authUser = Auth::user();
    //     $role = $request->query('role');
    //     $query = Institution::query();

    //     if ($authUser->isSuperAdmin()) {
    //         if ($role === 'admin') {
    //             $query->whereDoesntHave('employees.user', fn($q) => $q->where(
    //                 'role',
    //                 'admin'
    //             ));
    //         }
    //     } else {
    //         // Admin & Subadmin hanya bisa melihat instansinya sendiri
    //         $query->where('id', $authUser->employee->institution_id);
    //     }

    //     $institutions = $query->orderBy('nama')->get(['id', 'nama']);
    //     return response()->json($institutions);
    // }

    public function getInstitutionsForRole(Request $request)
    {
        $authUser = Auth::user();
        $role = $request->query('role');
        $targetUserId = $request->query('user_id'); // <-- Ambil user_id dari request

        $query = Institution::query();

        if ($authUser->isSuperAdmin()) {
            if ($role === 'admin') {
                $query->where(function ($q) use ($targetUserId) {
                    // Kondisi 1: Instansi yang sama sekali belum punya admin
                    $q->whereDoesntHave('employees.user', function ($sub) {
                        $sub->where('role', 'admin');
                    });
                    // Kondisi 2: ATAU instansi yang adminnya adalah user yang sedang diedit
                    if ($targetUserId) {
                        $q->orWhereHas('employees.user', function ($sub) use ($targetUserId) {
                            $sub->where('role', 'admin')->where('users.id', $targetUserId);
                        });
                    }
                });
            }
        } else {
            // Admin & Subadmin hanya bisa melihat instansinya sendiri
            $query->where('id', $authUser->employee->institution_id);
        }
        $institutions = $query->orderBy('nama')->get(['id', 'nama']);
        return response()->json($institutions);
    }
    public function getDepartmentsForRole(Request $request)
    {
        $authUser = Auth::user();
        $role = $request->query('role');
        $institutionId = $request->query('institution_id');

        if (!$institutionId) return response()->json([]);

        // Security check: admin/subadmin tidak bisa intip instansi lain
        if (
            !$authUser->isSuperAdmin() && $authUser->employee->institution_id != $institutionId
        ) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Departement::where('instansi_id', $institutionId);

        if ($authUser->isSubAdmin()) {
            // Subadmin hanya bisa melihat departemennya sendiri
            $query->where('id', $authUser->employee->department_id);
        } elseif ($role === 'subadmin') {
            // Superadmin/Admin yang ingin membuat subadmin, cari departemen yg belum punya subadmin
            $query->whereDoesntHave('employees.user', fn($q) => $q->where('role', 'subadmin'));
        }

        $departments = $query->orderBy('nama')->get(['id', 'nama']);
        return response()->json($departments);
    }

    public function getEmployeesForSelection(Request $request)
    {
        $authUser = Auth::user();
        $institutionId = $request->query('institution_id');
        $departmentId = $request->query('department_id');

        // Security check
        if ($authUser->isAdmin() && $authUser->employee->institution_id != $institutionId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        if ($authUser->isSubAdmin() && $authUser->employee->department_id != $departmentId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Employee::whereDoesntHave('user')->orderBy('nama');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        } elseif ($institutionId) {
            $query->where('institution_id', $institutionId);
        } else {
            // Jika tidak ada filter, batasi sesuai peran
            if ($authUser->isAdmin()) {
                $query->where('institution_id', $authUser->employee->institution_id);
            } elseif ($authUser->isSubAdmin()) {
                $query->where('department_id', $authUser->employee->department_id);
            }
        }

        $employees = $query->get(['id', 'nama']);
        return response()->json($employees);
    }
}
