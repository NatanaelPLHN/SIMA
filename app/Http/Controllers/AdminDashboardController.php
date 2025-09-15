<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function asset()
    {
        return view('admin.asset');
    }
    public function create_gerak()
    {
        // return view('admin.dashboard');
        return view('admin.create-gerak');
    }
}