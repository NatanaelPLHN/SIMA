<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala Dinas
        $budi = Employee::create([
            'nip' => '19780101001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Melati No.5',
            'telepon' => '08123456789',
            'department_id' => 1,
            'institution_id' => 1,
        ]);

        $siti = Employee::create([
            'nip' => '19800202002',
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Mawar No.8',
            'telepon' => '08129876543',
            'department_id' => 3,
            'institution_id' => 2,
        ]);

        // Kepala Bidang
        $anandita = Employee::create([
            'nip' => '19800303003',
            'nama' => 'Anandita Agung',
            'alamat' => 'Jl. Perjuangan No.10',
            'telepon' => '085865748901',
            'department_id' => 2,
            'institution_id' => 1,
        ]);

        $asep = Employee::create([
            'nip' => '19800404004',
            'nama' => 'Asep Saepudin',
            'alamat' => 'Jl. Suka Maju No.2',
            'telepon' => '085712345678',
            'department_id' => 4,
            'institution_id' => 2,
        ]);

        $dina = Employee::create([
            'nip' => '19800505005',
            'nama' => 'Dina Kartika',
            'alamat' => 'Jl. Bahagia No.12',
            'telepon' => '085623456789',
            'department_id' => 5,
            'institution_id' => 3,
        ]);

        // Staf Biasa
        Employee::create([
            'nip' => '19900101006',
            'nama' => 'Rahmat Hidayat',
            'alamat' => 'Jl. Damai No.4',
            'telepon' => '08125678901',
            'department_id' => 1,
            'institution_id' => 1,
        ]);

        Employee::create([
            'nip' => '19920102007',
            'nama' => 'Tasya Anindya',
            'alamat' => 'Jl. Anggrek No.9',
            'telepon' => '08131234567',
            'department_id' => 2,
            'institution_id' => 1,
        ]);

        Employee::create([
            'nip' => '19930303008',
            'nama' => 'Joko Purwanto',
            'alamat' => 'Jl. Cendana No.20',
            'telepon' => '082134567890',
            'department_id' => 3,
            'institution_id' => 2,
        ]);

        Employee::create([
            'nip' => '19940404009',
            'nama' => 'Mega Saputri',
            'alamat' => 'Jl. Raya Barat No.15',
            'telepon' => '08137777777',
            'department_id' => 5,
            'institution_id' => 3,
        ]);

        Employee::create([
            'nip' => '19950505010',
            'nama' => 'Rio Firmansyah',
            'alamat' => 'Jl. Kemakmuran No.8',
            'telepon' => '085688899900',
            'department_id' => 6,
            'institution_id' => 4,
        ]);

        // Set Kepala Bidang
        $anandita->department->update(['kepala_bidang_id' => $anandita->id]);
        $asep->department->update(['kepala_bidang_id' => $asep->id]);
        $dina->department->update(['kepala_bidang_id' => $dina->id]);
    }
}
