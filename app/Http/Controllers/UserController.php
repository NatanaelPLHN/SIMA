<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
      {
          // Mengaktifkan UserPolicy untuk semua metode di controller ini
          $this->authorizeResource(User::class, 'user');
      }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // Get all users with their related employee
    //     $users = User::with('employee')->paginate(10);

    //     return view('user.index', compact('users'));
    // }
    public function index()
    {
        $user = Auth::user();
        $query = User::query();

        // Sesuaikan query berdasarkan role user yang login
        if ($user->role === 'superadmin') {
            // Superadmin hanya melihat daftar admin
            $query->where('role', 'admin');
        } elseif ($user->role === 'admin') {
            // Admin hanya melihat daftar subadmin
            $query->where('role', 'subadmin');
        } elseif ($user->role === 'subadmin') {
            // Subadmin hanya melihat daftar user
            $query->where('role', 'user');
        } else {
            // Jika rolenya aneh, jangan tampilkan apa-apa
            $query->whereRaw('1 = 0');
        }

        $users = $query->with('employee')->paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        // $employees = Employee::all();
        // return view('user.create_user',compact('employees'));
        $employees = Employee::all();

          // Tentukan role apa yang boleh dibuat berdasarkan role user yang login
          $creatable_role = '';
          $user_role = Auth::user()->role;
          if ($user_role === 'superadmin') {
              $creatable_role = 'admin';
          } elseif ($user_role === 'admin') {
              $creatable_role = 'subadmin';
          } elseif ($user_role === 'subadmin') {
              $creatable_role = 'user';
          }

          return view('user.create_user', compact('employees', 'creatable_role'));
    }

    /**
     * Store a newly created resource in storage.
    */
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

        // Tentukan role baru secara otomatis, jangan ambil dari request
        $user_role = Auth::user()->role;
        $new_role = '';
        if ($user_role === 'superadmin') {
            $new_role = 'admin';
        } elseif ($user_role === 'admin') {
            $new_role = 'subadmin';
        } elseif ($user_role === 'subadmin') {
            $new_role = 'user';
        } else {
            // Jika role pembuat tidak valid, gagalkan.
            return back()->with('error', 'Anda tidak memiliki izin untuk membuat pengguna.');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $new_role; // Set role secara programatik

        User::create($validated);

        return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
    */
    public function show(User $user)
    {
        $user->load('employee');
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit(User $user)
    {
        $user->load('employee');
        $employees = Employee::all(); // Tambahkan ini

        return view('user.edit_user', compact('user', 'employees'));

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

          // Penting: Jangan izinkan mengubah role saat update untuk menjaga integritas
          // Jika role ingin diubah, prosesnya harus hapus dan buat baru.
          $original = $user->replicate();
          if (!empty($validated['password'])) {
              $validated['password'] = Hash::make($validated['password']);
          } else {
              unset($validated['password']);
          }
          $user->fill($validated);
          if (!$user->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data user.');
        }
          $user->update($validated);

          return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil diperbarui.');
      }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect(routeForRole('user', 'index'))->with('success', 'User berhasil dihapus.');
        } catch(\Exception $e){
            return redirect(routeForRole('user', 'index'))->with('error', 'Gagal menghapus akun. Akun masih memiliki data peminjaman.');
        }
    }
}
