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

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('layouts.profil', compact('user'));
        // return view('layouts.profil');
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'old-password' => 'required|min:6',
            'new-password' => 'required|min:6|confirmed|different:old-password',
        ], [
            'old-password.required' => 'Password Lama wajib diisi.',
            'old-password.min' => 'Password Lama minimal 6 karakter.',
            'new-password.required' => 'Password Baru wajib diisi.',
            'new-password.min' => 'Password Baru minimal 6 karakter.',
            'new-password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new-password.different' => 'Password baru tidak boleh sama dengan password lama.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->input('old-password'), $user->password)) {
            return back()->withErrors(['old-password' => 'Password lama tidak cocok.']);
        }

        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
        // return view('layouts.profil', compact('user'));
        // return redirect(routeForRole('profile', 'index'))->with('success', 'Password berhasil diubah.');

        // return view('layouts.profil');
    }
}
