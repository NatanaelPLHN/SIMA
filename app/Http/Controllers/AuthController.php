<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function showLoginForm()
    {
    Auth::logout();
    // request()->session()->invalidate();
    // request()->session()->regenerateToken();

    return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
             if ($user->isSuperAdmin()) {
                    return redirect()->intended('/superadmin/dashboard');
                } elseif ($user->isAdmin()) {
                    return redirect()->intended('/admin/dashboard');
                } else {
                    return redirect()->intended('/user/dashboard');
                }
                
        }

        return redirect()->back()->with('loginError', 'Email atau password salah!');


    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    
}