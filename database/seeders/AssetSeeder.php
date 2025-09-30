<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\AsetBergerak;
use App\Models\AsetTidakBergerak;
use App\Models\AsetHabisPakai;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder for Aset Bergerak
        Asset::factory()
            ->count(15)
            ->has(AsetBergerak::factory(), 'bergerak')
            ->create([
                'jenis_aset' => 'bergerak',
            ]);

        // Seeder for Aset Tidak Bergerak
        Asset::factory()
            ->count(15)
            ->has(AsetTidakBergerak::factory(), 'tidakBergerak')
            ->create([
                'jenis_aset' => 'tidak_bergerak',
            ]);

        // Seeder for Aset Habis Pakai
        Asset::factory()
            ->count(15)
            ->has(AsetHabisPakai::factory(), 'habisPakai')
            ->create([
                'jenis_aset' => 'habis_pakai',
            ]);
    }
}
