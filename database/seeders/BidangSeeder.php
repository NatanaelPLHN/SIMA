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
            'kepala_bidang_id' => null, // nanti bisa diisi Karyawawan
            'lokasi' => 'Gedung A Lt.2',
            'instansi_id' => 1, // Dinas Pendidikan
            'alias' => 'BiKur',
        ]);

        Departement::create([
            'nama' => 'Bidang Kesehatan Masyarakat',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung B Lt.3',
            'instansi_id' => 2, // Dinas Kesehatan
            'alias' => 'BiKes',
        ]);
    }
}
