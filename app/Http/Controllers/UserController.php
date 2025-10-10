<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Departement;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
            $query->where('role', 'admin');
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

        $users = $query->with('employee')->paginate(10);
        // dd($user);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $login = Auth::user();
        $user_role = $login->role;

        $employees = collect();
        $creatable_role = '';

        if ($user_role === 'superadmin') {
            $creatable_role = 'admin';
            $kepalaInstansiIds = Institution::whereNotNull('kepala_instansi_id')->pluck('kepala_instansi_id');
            $employees = Employee::whereIn('id', $kepalaInstansiIds)
                ->whereDoesntHave('user')
                ->orderBy('nama')
                ->get();
        } elseif ($user_role === 'admin') {
            $creatable_role = 'subadmin';
            $kepalaDepartemenIds = Departement::where('instansi_id', $login->employee->institution_id)
                ->whereNotNull('kepala_bidang_id')
                ->pluck('kepala_bidang_id');
            $employees = Employee::whereIn('id', $kepalaDepartemenIds)
                ->whereDoesntHave('user')
                ->orderBy('nama')
                ->get();
        } elseif ($user_role === 'subadmin') {
            $creatable_role = 'user';
            $employees = Employee::where('department_id', $login->employee->department_id)
                ->whereDoesntHave('user')
                ->orderBy('nama')
                ->get();
        }

        return view('user.create_user', compact('creatable_role', 'employees', 'login'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'karyawan_id' => 'required|exists:employees,id|unique:users,karyawan_id',
    ], [
        'email.unique' => 'Email sudah digunakan.',
        'email.required' => 'Email wajib diisi.',
        'karyawan_id.unique' => 'Karyawan ini sudah memiliki akun.',
    ]);

    $user = Auth::user();
    $user_role = $user->role;
    $new_role = '';
    $employee = Employee::find($validated['karyawan_id']);

    // Tentukan role baru & validasi tambahan
    if ($user_role === 'superadmin') {
        $new_role = 'admin';
        $isKepalaInstansi = Institution::where('kepala_instansi_id', $employee->id)->exists();
        if (!$isKepalaInstansi) {
            return back()->withInput()->withErrors(['karyawan_id' => 'Superadmin hanya bisa membuat akun untuk Kepala Instansi.']);
        }
    } elseif ($user_role === 'admin') {
        $new_role = 'subadmin';
        $isKepalaDepartemen = Departement::where('kepala_bidang_id', $employee->id)->exists();
        if (!$isKepalaDepartemen) {
            return back()->withInput()->withErrors(['karyawan_id' => 'Admin hanya bisa membuat akun untuk Kepala Departemen.']);
        }
    } elseif ($user_role === 'subadmin') {
        $new_role = 'user';
        if ($employee->department_id !== $user->employee->department_id) {
            return back()->withInput()->withErrors(['karyawan_id' => 'Subadmin hanya bisa membuat akun untuk karyawan di departemennya sendiri.']);
        }
    } else {
        return back()->with('error', 'Anda tidak memiliki izin untuk membuat pengguna.');
    }

    try {
        DB::beginTransaction();

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $new_role;

        User::create($validated);

        DB::commit();

        return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil ditambahkan.');
    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
}


    public function show(User $user)
    {
        $user->load('employee');
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // ORIGINAL------------------------------

    // public function edit(User $user)
    // {
    //     $login = Auth::user();
    //     $user->load('employee');
    //     $employees = Employee::all(); // Tambahkan ini
    //     // $employees = Employee::with(['department', 'institution', 'user']);

    //     return view('user.edit_user', compact('user', 'employees', 'login'));
    // }
    public function edit(User $user)
    {
        $login = Auth::user();
        $user->load('employee');

        $query = Employee::query();

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

        return view('user.edit_user', compact('user', 'employees', 'login'));
    }
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, User $user)
    // {
    //     $validated = $request->validate([
    //         'email'       => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
    //         'password'    => 'nullable|min:6|confirmed',
    //         'role'        => ['required', Rule::in(['superadmin', 'admin', 'subadmin', 'user'])],
    //         'karyawan_id' => 'nullable|exists:employees,id',
    //     ], [
    //         'email.unique'       => 'Email sudah digunakan.',
    //         'email.required'     => 'Email wajib diisi.',
    //         'role.required'      => 'Role wajib diisi.',
    //         'role.in'            => 'Role tidak valid.',
    //         'password.min'       => 'Password minimal 6 karakter.',
    //         'password.confirmed' => 'Konfirmasi password tidak cocok.',
    //         'karyawan_id.exists' => 'Karyawan tidak ditemukan.',
    //     ]);

    //     $original = $user->replicate();

    //     // Handle password: only hash if it's provided
    //     if (!empty($validated['password'])) {
    //         $validated['password'] = Hash::make($validated['password']);
    //     } else {
    //         unset($validated['password']);
    //     }

    //     $user->fill($validated);

    //     if (!$user->isDirty()) {
    //         return back()->with('info', 'Tidak ada perubahan pada data user.');
    //     }

    //     $user->update($validated);

    //     return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil diperbarui.');
    // }
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'email'       => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password'    => 'nullable|min:6|confirmed',
            'karyawan_id' => ['nullable', 'exists:employees,id', Rule::unique('users', 'karyawan_id')->ignore($user->id)],
        ], [
            'email.unique'       => 'Email sudah digunakan.',
            'email.required'     => 'Email wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'karyawan_id.exists' => 'Karyawan tidak ditemukan.',
            'karyawan_id.unique' => 'Karyawan ini sudah memiliki akun.',
        ]);

    $original = $user->replicate();

    try {
        DB::beginTransaction();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->fill($validated);

        if (!$user->isDirty()) {
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
            if (!$department || $department->instansi_id != $user->employee?->institution_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $employees = Employee::where('department_id', $departmentId)
            ->whereDoesntHave('user')
            ->orderBy('nama')
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
}
