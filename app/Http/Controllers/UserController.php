<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users with their related employee
        $users = User::with('employee')->paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        $employees = Employee::all();
        return view('user.create_user',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => ['required', Rule::in(['superadmin', 'admin', 'subadmin', 'user'])],
            'karyawan_id' => 'required|exists:employees,id',
        ], [
            'email.unique' => 'Email sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

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
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'email'       => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password'    => 'nullable|min:6|confirmed',
            'role'        => ['required', Rule::in(['superadmin', 'admin', 'subadmin', 'user'])],
            'karyawan_id' => 'nullable|exists:employees,id',
        ], [
            'email.unique'       => 'Email sudah digunakan.',
            'email.required'     => 'Email wajib diisi.',
            'role.required'      => 'Role wajib diisi.',
            'role.in'            => 'Role tidak valid.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'karyawan_id.exists' => 'Karyawan tidak ditemukan.',
        ]);

        $original = $user->replicate();

        // Handle password: only hash if it's provided
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
