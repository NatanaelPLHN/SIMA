<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.asset');
        // return view('admin.dashboard');
    }
    public function create_gerak()
    {
        // return view('admin.dashboard');
        return view('admin.create-gerak');
    }
}