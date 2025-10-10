<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $k1 = Employee::create([
            'nip' => '19780101001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Melati No.5',
            'telepon' => '08123456789',
            // 'department_id' => 1,
        ]);

        $k2 = Employee::create([
            'nip' => '19800202002',
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Mawar No.8',
            'telepon' => '08129876543',
            // 'department_id' => 1,
        ]);

        $k3 = Employee::create([
            'nip' => '19800203003',
            'nama' => 'Anandita Agung',
            'alamat' => 'Jl. Perjuangan',
            'telepon' => '085865748901',
            'department_id' => 1,
            'institution_id' => 1,
        ]);
        $k4 = Employee::create([
            'nip' => '19800203004',
            'nama' => 'Asep',
            'alamat' => 'Jl. Perjuangan',
            'telepon' => '085865748901',
            'department_id' => 2,
            'institution_id' => 2,
        ]);

        // Update Kepala Bidang
        $k1->update(['institution_id' => $k1->id]);
        $k2->update(['institution_id' => $k2->id]);
        $k3->department->update(['kepala_bidang_id' => $k3->id]);
        $k4->department->update(['kepala_bidang_id' => $k4->id]);
    }
}
