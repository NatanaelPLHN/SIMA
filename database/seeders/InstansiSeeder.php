<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        Institution::create([
            'nama' => 'Dinas Pendidikan',
            'pemerintah' => 'Pemerintah Kota',
            'telepon' => '021-123456',
            'email' => 'disdik@kotax.go.id',
            'alamat' => 'Jl. Merdeka No. 1, Kota X',
            'alias' => 'Diknas',
            'kepala_instansi_id' => null,

        ]);

        Institution::create([
            'nama' => 'Dinas Kesehatan',
            'pemerintah' => 'Pemerintah Kota',
            'telepon' => '021-654321',
            'email' => 'dinkes@kotax.go.id',
            'alamat' => 'Jl. Sehat No. 10, Kota X',
            'alias' => 'DinKes',
            'kepala_instansi_id' => null,
        ]);
    }
}
