<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        Departement::create([
            'nama' => 'Bidang Kurikulum',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung A Lt.2',
            'instansi_id' => 1,
            'alias' => 'BiKur',
        ]);

        Departement::create([
            'nama' => 'Bidang Tenaga Pendidik',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung A Lt.3',
            'instansi_id' => 1,
            'alias' => 'BiTen',
        ]);

        Departement::create([
            'nama' => 'Bidang Kesehatan Masyarakat',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung B Lt.3',
            'instansi_id' => 2,
            'alias' => 'BiKes',
        ]);

        Departement::create([
            'nama' => 'Bidang Pelayanan Rumah Sakit',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung B Lt.2',
            'instansi_id' => 2,
            'alias' => 'BiRS',
        ]);

        Departement::create([
            'nama' => 'Bidang Rehabilitasi Sosial',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung C Lt.1',
            'instansi_id' => 3,
            'alias' => 'BiReSos',
        ]);

        Departement::create([
            'nama' => 'Bidang Transportasi Darat',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung D Lt.1',
            'instansi_id' => 4,
            'alias' => 'BiTransDar',
        ]);
    }
}
