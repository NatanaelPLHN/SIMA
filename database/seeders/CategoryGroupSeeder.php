<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryGroup;

class CategoryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            ['nama' => 'Elektronik', 'alias' => 'elektronik', 'deskripsi' => 'Semua aset elektronik'],
            ['nama' => 'Furniture', 'alias' => 'furniture', 'deskripsi' => 'Perabot kantor & rumah'],
            ['nama' => 'Kendaraan', 'alias' => 'kendaraan', 'deskripsi' => 'Semua jenis kendaraan'],
            ['nama' => 'Alat Tulis', 'alias' => 'alat-tulis', 'deskripsi' => 'Peralatan tulis & kantor'],
            ['nama' => 'Bangunan', 'alias' => 'bangunan', 'deskripsi' => 'Gedung dan infrastruktur'],
        ];

        foreach ($groups as $group) {
            CategoryGroup::create($group);
        }
    }
}
