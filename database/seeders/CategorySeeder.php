<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = CategoryGroup::all();

        foreach ($groups as $group) {
            for ($i = 1; $i <= 10; $i++) {
                $nama = $group->nama . " Kategori " . $i;

                Category::create([
                    'nama' => $nama,
                    'alias' => Str::slug($nama) . '-' . $group->id,
                    'deskripsi' => "Kategori $i untuk grup " . $group->nama,
                    'category_group_id' => $group->id,
                ]);
            }
        }
    }
}
