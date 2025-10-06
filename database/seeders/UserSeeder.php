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
        User::create([
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'karyawan_id' => null,
        ]);

        // User::create([
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'admin',
        //     'karyawan_id' => Employee::where('nama', 'Siti Aminah')->first()->id,
        // ]);

        // User::create([
        //     'email' => 'subadmin@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'subadmin',
        //     'karyawan_id' => Employee::where('nama', 'Anandita Agung')->first()->id,
        // ]);
    }
}
