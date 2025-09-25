<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        Bidang::create([
            'nama' => 'Bidang Kurikulum',
            'kepala_bidang_id' => null, // nanti bisa diisi Karyawawan
            'lokasi' => 'Gedung A Lt.2',
            'instansi_id' => 1, // Dinas Pendidikan
        ]);

        Bidang::create([
            'nama' => 'Bidang Kesehatan Masyarakat',
            'kepala_bidang_id' => null,
            'lokasi' => 'Gedung B Lt.3',
            'instansi_id' => 2, // Dinas Kesehatan
        ]);
    }
}
