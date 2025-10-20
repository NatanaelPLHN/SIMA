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

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = User::query();
        $search = $request->input('search');

        if ($user->role === 'superadmin') {
            // $query->where('role', 'admin');
            $query->whereIn('role', ['admin', 'subadmin', 'user']);
        } elseif ($user->role === 'admin') {
            $query->whereIn('role', ['subadmin', 'user'])
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

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('employee', function ($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%");
                })
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")

                    ->orWhereHas('employee.institution', function ($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%"); // asumsi kolom nama instansi = 'name'
                    })
                    // Cari di nama department
                    ->orWhereHas('employee.department', function ($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%"); // asumsi kolom nama department = 'name'
                    });
            });
        }

        $users = $query->with('employee.institution', 'employee.department')
            ->paginate(10)
            ->appends(['search' => $search]); // Pertahankan parameter search di pagination

        return view('user.index', compact('users'));
        // $users = $query->with('employee.institution', 'employee.department')->paginate(10);
        // return view('user.index', compact('users'));
        // $users = $query->with('employee')->paginate(10);
        // return view('user.index', compact('users'));
    }

    // public function create()
    // {
    //     $this->authorize('create', User::class);
    //     $authUser = Auth::user();
    //     $viewData = [];

    //     if ($authUser->isSuperAdmin()) {
    //         $viewData['roles'] = ['admin' => 'Admin', 'subadmin' => 'Sub Admin', 'user' => 'User'];
    //     } elseif ($authUser->isAdmin()) {
    //         $viewData['roles'] = ['subadmin' => 'Sub Admin', 'user' => 'User'];

    //         $allDepartments = Departement::where('instansi_id', $authUser->employee->institution_id)
    //             ->orderBy('nama')
    //             ->get();

    //         $departmentsWithSubadmin = User::where('role', 'subadmin')
    //             ->whereHas('employee.department', function ($query) use ($authUser) {
    //                 $query->where('instansi_id', $authUser->employee->institution_id);
    //             })
    //             ->with('employee:id,department_id')
    //             ->get()
    //             ->pluck('employee.department_id')
    //             ->filter();

    //         // === PERBAIKAN DI SINI ===
    //         // Gunakan ->values()->all() untuk memastikan hasilnya adalah array bersih
    //         $viewData['departmentsForSubadmin'] = $allDepartments->whereNotIn('id', $departmentsWithSubadmin)->values()->all();

    //         $viewData['allDepartments'] = $allDepartments;

    //         $viewData['employees'] = Employee::where('institution_id', $authUser->employee->institution_id)
    //             ->whereDoesntHave('user')
    //             ->orderBy('nama')
    //             ->get();
    //     } elseif ($authUser->isSubAdmin()) {
    //         $viewData['roles'] = ['user' => 'User'];
    //     }

    //     return view('user.create_user', $viewData);
    // }

    public function create()
    {
        $this->authorize('create', User::class);
        $authUser = Auth::user();
        $viewData = [];

        if ($authUser->isSuperAdmin()) {
            $viewData['roles'] = ['admin' => 'Admin', 'subadmin' => 'Sub Admin', 'user' => 'User'];
        } elseif ($authUser->isAdmin()) {
            $viewData['roles'] = ['subadmin' => 'Sub Admin', 'user' => 'User'];

            $allDepartments = Departement::where('instansi_id', $authUser->employee->institution_id)
                ->orderBy('nama')
                ->get();

            $departmentsWithSubadmin = User::where('role', 'subadmin')
                ->whereHas('employee.department', function ($query) use ($authUser) {
                    $query->where('instansi_id', $authUser->employee->institution_id);
                })
                ->with('employee:id,department_id')
                ->get()
                ->pluck('employee.department_id')
                ->filter();

            $viewData['departmentsForSubadmin'] = $allDepartments->whereNotIn('id', $departmentsWithSubadmin)->values();

            $viewData['allDepartments'] = $allDepartments;

            $viewData['employees'] = Employee::where('institution_id', $authUser->employee->institution_id)
                ->whereDoesntHave('user')
                ->orderBy('nama')
                ->get();
        } elseif ($authUser->isSubAdmin()) {
            // === LOGIKA BARU UNTUK SUBADMIN ===
            $viewData['roles'] = ['user' => 'User'];

            // Ambil semua karyawan di departemen subadmin yang belum punya akun
            $viewData['employees'] = Employee::where('department_id', $authUser->employee->department_id)
                ->whereDoesntHave('user')
                ->orderBy('nama')
                ->get();
        }

        return view('user.create_user', $viewData);
    }


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
        $this->authorize('update', $user);
        $authUser = Auth::user();
        $viewData = ['user' => $user->load('employee.institution', 'employee.department')];

        if ($authUser->isSuperAdmin()) {
            // Untuk Superadmin, kita biarkan AJAX yang bekerja.
            // Kita hanya perlu menyediakan daftar role.
            $viewData['roles'] = ['admin' => 'Admin', 'subadmin' => 'Sub Admin', 'user' => 'User'];
        } elseif ($authUser->isAdmin()) {
            // Untuk Admin, siapkan semua data di awal.
            $viewData['roles'] = ['subadmin' => 'Sub Admin', 'user' => 'User'];
            $institutionId = $authUser->employee->institution_id;

            // 1. Ambil semua departemen di instansi Admin
            $viewData['departments'] = Departement::where('instansi_id', $institutionId)
                ->orderBy('nama')
                ->get();

            // 2. Ambil semua karyawan di instansi Admin yang:
            //    - Belum punya akun, ATAU
            //    - Adalah karyawan yang sedang diedit saat ini.
            $viewData['employees'] = Employee::where('institution_id', $institutionId)
                ->where(function ($query) use ($user) {
                    $query->whereDoesntHave('user')
                        ->orWhere('id', $user->karyawan_id);
                })
                ->orderBy('nama')
                ->get();
        } elseif ($authUser->isSubAdmin()) {
            // Untuk Subadmin, siapkan data yang lebih terbatas.
            $viewData['roles'] = ['user' => 'User'];
            $departmentId = $authUser->employee->department_id;

            // Ambil karyawan di departemen Subadmin yang:
            // - Belum punya akun, ATAU
            // - Adalah karyawan yang sedang diedit.
            $viewData['employees'] = Employee::where('department_id', $departmentId)
                ->where(function ($query) use ($user) {
                    $query->whereDoesntHave('user')
                        ->orWhere('id', $user->karyawan_id);
                })
                ->orderBy('nama')
                ->get();
        }

        return view('user.edit_user', $viewData);
    }



    // public function update(Request $request, User $user)
    // {
    //     $this->authorize('update', $user);

    //     // === PERBAIKAN VALIDASI DI SINI ===
    //     $validated = $request->validate([
    //         'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
    //         'password' => 'nullable|min:6|confirmed',
    //         // karyawan_id wajib diisi JIKA role juga diisi (artinya bagian edit role dibuka)
    //         'karyawan_id' => ['required_with:role', 'nullable', 'exists:employees,id', Rule::unique('users', 'karyawan_id')->ignore($user->id)],
    //         // 'role' => 'sometimes|in:admin,subadmin,user',
    //     ], [
    //         'email.unique' => 'Email sudah digunakan.',
    //         'email.required' => 'Email wajib diisi.',
    //         'password.min' => 'Password minimal 6 karakter.',
    //         'password.confirmed' => 'Konfirmasi password tidak cocok.',
    //         'karyawan_id.exists' => 'Karyawan tidak ditemukan.',
    //         'karyawan_id.unique' => 'Karyawan ini sudah memiliki akun.',
    //         // Tambahkan pesan error baru
    //         'karyawan_id.required_with' => 'Anda harus memilih ulang karyawan jika mengubah role.',
    //         'role.in' => 'Role yang dipilih tidak valid.',
    //     ]);

    //     // Validasi Bisnis Duplikat Role
    //     if ($request->filled('role') && $request->filled('karyawan_id')) {
    //         $newEmployee = Employee::find($validated['karyawan_id']);
    //         $newRole = $validated['role'];

    //         if ($newRole === 'admin') {
    //             $existingAdmin = User::where('role', 'admin')
    //                 ->where('id', '!=', $user->id)
    //                 ->whereHas('employee', function ($query) use ($newEmployee) {
    //                     $query->where('institution_id', $newEmployee->institution_id);
    //                 })
    //                 ->exists();

    //             if ($existingAdmin) {
    //                 return back()->withInput()->with('error', 'Instansi ini sudah memiliki Admin.');
    //             }
    //         }

    //         if ($newRole === 'subadmin') {
    //             if ($newEmployee->department_id) {
    //                 $existingSubadmin = User::where('role', 'subadmin')
    //                     ->where('id', '!=', $user->id)
    //                     ->whereHas('employee', function ($query) use ($newEmployee) {
    //                         $query->where('department_id', $newEmployee->department_id);
    //                     })
    //                     ->exists();

    //                 if ($existingSubadmin) {
    //                     return back()->withInput()->with('error', 'Departemen ini sudah memiliki Sub Admin.');
    //                 }
    //             }
    //         }
    //     }

    //     try {
    //         DB::beginTransaction();

    //         if (! empty($validated['password'])) {
    //             $validated['password'] = Hash::make($validated['password']);
    //         } else {
    //             unset($validated['password']);
    //         }

    //         // Jika role tidak diubah, jangan sertakan karyawan_id dalam update
    //         // kecuali memang diisi secara eksplisit.
    //         if (!$request->filled('role') && !$request->filled('karyawan_id')) {
    //             unset($validated['karyawan_id']);
    //         }

    //         $user->fill($validated);

    //         if (! $user->isDirty()) {
    //             DB::rollBack();
    //             return back()->with('info', 'Tidak ada perubahan pada data user.');
    //         }

    //         $user->update($validated);

    //         DB::commit();

    //         return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil diperbarui.');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
    //     }
    // }
    // public function update(Request $request, User $user)
    // {
    //     $this->authorize('update', $user);

    //     // Validasi disesuaikan: role bersifat opsional, karyawan_id dihilangkan
    //     $validated = $request->validate([
    //         'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
    //         'password' => 'nullable|min:6|confirmed',
    //         'role' => 'sometimes|in:admin,subadmin,user', // 'sometimes' berarti hanya divalidasi jika ada di request
    //     ], [
    //         'email.unique' => 'Email sudah digunakan.',
    //         'email.required' => 'Email wajib diisi.',
    //         'password.min' => 'Password minimal 6 karakter.',
    //         'password.confirmed' => 'Konfirmasi password tidak cocok.',
    //         'role.in' => 'Role yang dipilih tidak valid.',
    //     ]);

    //     // Ambil data karyawan yang saat ini terhubung dengan user
    //     $currentEmployee = $user->employee;

    //     // Validasi Bisnis Duplikat Role jika role diubah dan user punya data karyawan
    //     if ($request->filled('role') && $currentEmployee) {
    //         $newRole = $validated['role'];

    //         // 1. Cek duplikat Admin
    //         if ($newRole === 'admin') {
    //             $existingAdmin = User::where('role', 'admin')
    //                 ->where('id', '!=', $user->id) // Abaikan user yang sedang diedit
    //                 ->whereHas('employee', function ($query) use ($currentEmployee) {
    //                     $query->where('institution_id', $currentEmployee->institution_id);
    //                 })
    //                 ->exists();

    //             if ($existingAdmin) {
    //                 return back()->withInput()->with('error', 'Instansi ini sudah memiliki Admin.');
    //             }
    //         }

    //         // 2. Cek duplikat Subadmin
    //         if ($newRole === 'subadmin' && $currentEmployee->department_id) {
    //             $existingSubadmin = User::where('role', 'subadmin')
    //                 ->where('id', '!=', $user->id) // Abaikan user yang sedang diedit
    //                 ->whereHas('employee', function ($query) use ($currentEmployee) {
    //                     $query->where('department_id', $currentEmployee->department_id);
    //                 })
    //                 ->exists();

    //             if ($existingSubadmin) {
    //                 return back()->withInput()->with('error', 'Departemen ini sudah memiliki Sub Admin.');
    //             }
    //         }
    //     }

    //     try {
    //         DB::beginTransaction();

    //         // Siapkan data untuk diupdate
    //         $updateData = [
    //             'email' => $validated['email'],
    //         ];

    //         if (!empty($validated['password'])) {
    //             $updateData['password'] = Hash::make($validated['password']);
    //         }

    //         if ($request->filled('role')) {
    //             $updateData['role'] = $validated['role'];
    //         }

    //         $user->fill($updateData);

    //         if (!$user->isDirty()) {
    //             DB::rollBack();
    //             return back()->with('info', 'Tidak ada perubahan pada data user.');
    //         }

    //         $user->update($updateData);

    //         DB::commit();

    //         return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil diperbarui.');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data: ' .
    //             $e->getMessage());
    //     }
    // }
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        // Validasi dasar untuk input yang diterima
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
            'role' => 'nullable|in:admin,subadmin,user',
        ], [
            'email.unique' => 'Email sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        // Lakukan validasi bisnis hanya jika role diubah
        if ($request->filled('role')) {
            $newRole = $validated['role'];
            $currentEmployee = $user->employee;

            // Jika pengguna tidak terhubung dengan data karyawan, tidak boleh jadi admin/subadmin
            if (!$currentEmployee && in_array($newRole, ['admin', 'subadmin'])) {
                return back()->withInput()->with('error', 'Hanya akun yang terhubung dengan data karyawan yang bisa menjadi Admin atau Sub Admin.');
            }

            if ($currentEmployee) {
                // 1. Validasi untuk role Admin
                if ($newRole === 'admin') {
                    $existingAdmin = User::where('role', 'admin')
                        ->where('id', '!=', $user->id)
                        ->whereHas('employee', function ($query) use ($currentEmployee) {
                            $query->where('institution_id', $currentEmployee->institution_id);
                        })
                        ->exists();

                    if ($existingAdmin) {
                        return back()->withInput()->with('error', 'Instansi ini sudah memiliki Admin.');
                    }
                }

                // 2. Validasi untuk role Subadmin
                if ($newRole === 'subadmin') {
                    // Pastikan karyawan tersebut memiliki data departemen
                    if (!$currentEmployee->department_id) {
                        return back()->withInput()->with('error', 'Karyawan ini tidak terdaftar di departemen manapun, sehingga tidak bisa menjadi Sub Admin.');
                    }

                    $existingSubadmin = User::where('role', 'subadmin')
                        ->where('id', '!=', $user->id)
                        ->whereHas('employee', function ($query) use ($currentEmployee) {
                            $query->where('department_id', $currentEmployee->department_id);
                        })
                        ->exists();

                    if ($existingSubadmin) {
                        return back()->withInput()->with('error', 'Departemen ini sudah memiliki Sub Admin.');
                    }
                }
            }
        }

        try {
            DB::beginTransaction();

            // Siapkan data untuk diupdate
            $updateData = ['email' => $validated['email']];
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }
            if ($request->filled('role')) {
                $updateData['role'] = $validated['role'];
            }

            $user->fill($updateData);

            if (!$user->isDirty()) {
                DB::rollBack();
                return back()->with('info', 'Tidak ada perubahan pada data user.');
            }

            $user->update($updateData);

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
        $query = User::query();
        if ($authUser->role === 'superadmin') {
            // Superadmin can export only admin users
            // $users = User::where('role', 'admin')->get();
            $query->whereIn('role', ['admin', 'subadmin', 'user']);
        } elseif ($authUser->role === 'admin') {
            // Admin can export only subadmin users
            // $users = User::where('role', 'subadmin')->get();
            // Admin mengekspor subadmin dan user di dalam instansinya
            $query->whereIn('role', ['subadmin', 'user'])
                ->whereHas('employee', function ($q) use ($authUser) {
                    $q->where('institution_id', $authUser->employee->institution_id);
                });
        } elseif ($authUser->role === 'subadmin') {
            // Subadmin can export only normal users
            // $users = User::where('role', 'user')->get();
            $query->where('role', 'user')
                ->whereHas('employee', function ($q) use ($authUser) {
                    $q->where('department_id', $authUser->employee->department_id);
                });
        } else {
            abort(403, 'You are not authorized to export user data.');
        }

        // === PENAMBAHAN SORTING DI SINI ===
        // 1. Join dengan tabel employees untuk bisa sorting berdasarkan nama karyawan
        // 2. Urutkan berdasarkan urutan custom untuk role
        // 3. Urutkan berdasarkan nama karyawan
        $users = $query->join('employees', 'users.karyawan_id', '=', 'employees.id')
            ->orderBy(DB::raw("CASE users.role WHEN 'admin' THEN 1 WHEN 'subadmin' THEN 2 WHEN 'user' THEN 3 ELSE 4 END"))
            ->orderBy('employees.nama', 'asc')
            ->select('users.*') // Pilih semua kolom dari tabel users untuk menghindari konflik nama kolom
            ->get();
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
