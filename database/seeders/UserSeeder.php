<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        User::create([
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'karyawan_id' => null,
        ]);

        // Admin Dinas Pendidikan (not every instansi has admin)
        User::create([
            'email' => 'admin.disdik@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'karyawan_id' => Employee::where('nama', 'Budi Santoso')->first()->id,
        ]);

        // Subadmin Dinas Kesehatan
        User::create([
            'email' => 'subadmin.dinkes@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'subadmin',
            'karyawan_id' => Employee::where('nama', 'Siti Aminah')->first()->id,
        ]);

        // Admin Dinas Sosial
        User::create([
            'email' => 'admin.dinsos@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'karyawan_id' => Employee::where('nama', 'Dina Kartika')->first()->id,
        ]);
    }
}
