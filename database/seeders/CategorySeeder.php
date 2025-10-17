<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik' => [
                'Laptop', 'Komputer', 'Printer', 'Proyektor', 'Scanner'
            ],
            'Furniture' => [
                'Meja', 'Kursi', 'Lemari Arsip', 'Rak Buku', 'Filing Cabinet'
            ],
            'Kendaraan' => [
                'Mobil Dinas', 'Motor Dinas', 'Sepeda Kantor'
            ],
            'Alat Tulis' => [
                'Pulpen', 'Buku Catatan', 'Kertas A4', 'Map Dokumen', 'Stapler'
            ],
            'Bangunan' => [
                'Ruang Rapat', 'Gudang', 'Kantor Utama'
            ],
        ];

        foreach ($categories as $groupName => $names) {
            $group = CategoryGroup::where('nama', $groupName)->first();

            if (!$group) continue;

            foreach ($names as $name) {
                Category::create([
                    'nama' => $name,
                    'alias' => Str::slug($name),
                    'deskripsi' => "Kategori aset untuk $groupName - $name",
                    'category_group_id' => $group->id,
                ]);
            }
        }
    }
}
