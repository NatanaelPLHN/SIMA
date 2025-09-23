<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $k1 = Employee::create([
            'nip' => '19780101001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Melati No.5',
            'telepon' => '08123456789',
            'department_id' => 1, // Bidang Kurikulum
        ]);

        $k2 = Employee::create([
            'nip' => '19800202002',
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Mawar No.8',
            'telepon' => '08129876543',
            'department_id' => 2, // Bidang Kesehatan Masyarakat
        ]);

        // Update Kepala Bidang
        $k1->bidang->update(['kepala_bidang_id' => $k1->id]);
        $k2->bidang->update(['kepala_bidang_id' => $k2->id]);
    }
}
