<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Dinas Pendidikan',
                'alias' => 'Diknas',
                'email' => 'disdik@kotax.go.id',
                'alamat' => 'Jl. Merdeka No. 1, Kota X',
                'telepon' => '081234567890',
            ],
            [
                'nama' => 'Dinas Kesehatan',
                'alias' => 'Dinkes',
                'email' => 'dinkes@kotax.go.id',
                'alamat' => 'Jl. Sehat No. 10, Kota X',
                'telepon' => '081365432109',
            ],
            [
                'nama' => 'Dinas Sosial',
                'alias' => 'Dinsos',
                'email' => 'dinsos@kotax.go.id',
                'alamat' => 'Jl. Kasih No. 2, Kota X',
                'telepon' => '082122334455',
            ],
            [
                'nama' => 'Dinas Perhubungan',
                'alias' => 'Dishub',
                'email' => 'dishub@kotax.go.id',
                'alamat' => 'Jl. Transport No. 5, Kota X',
                'telepon' => '081277889900',
            ],
            [
                'nama' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'alias' => 'PUPR',
                'email' => 'dpupr@kotax.go.id',
                'alamat' => 'Jl. Pembangunan No. 3, Kota X',
                'telepon' => '081933445566',
            ],
            [
                'nama' => 'Dinas Lingkungan Hidup',
                'alias' => 'DLH',
                'email' => 'dlh@kotax.go.id',
                'alamat' => 'Jl. Hijau No. 7, Kota X',
                'telepon' => '081199887766',
            ],
            [
                'nama' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'alias' => 'Disdukcapil',
                'email' => 'disdukcapil@kotax.go.id',
                'alamat' => 'Jl. Identitas No. 8, Kota X',
                'telepon' => '082244556677',
            ],
            [
                'nama' => 'Dinas Pariwisata dan Kebudayaan',
                'alias' => 'Disparbud',
                'email' => 'disparbud@kotax.go.id',
                'alamat' => 'Jl. Wisata No. 9, Kota X',
                'telepon' => '082355667788',
            ],
            [
                'nama' => 'Dinas Komunikasi dan Informatika',
                'alias' => 'Diskominfo',
                'email' => 'diskominfo@kotax.go.id',
                'alamat' => 'Jl. Teknologi No. 11, Kota X',
                'telepon' => '081511223344',
            ],
            [
                'nama' => 'Dinas Ketahanan Pangan dan Pertanian',
                'alias' => 'DKPP',
                'email' => 'dkpp@kotax.go.id',
                'alamat' => 'Jl. Tani No. 12, Kota X',
                'telepon' => '081688990011',
            ],
            [
                'nama' => 'Dinas Tenaga Kerja dan Transmigrasi',
                'alias' => 'Disnakertrans',
                'email' => 'disnakertrans@kotax.go.id',
                'alamat' => 'Jl. Pekerja No. 14, Kota X',
                'telepon' => '081777665544',
            ],
            [
                'nama' => 'Dinas Pemadam Kebakaran dan Penyelamatan',
                'alias' => 'Damkar',
                'email' => 'damkar@kotax.go.id',
                'alamat' => 'Jl. Api No. 6, Kota X',
                'telepon' => '081278945612',
            ],
            [
                'nama' => 'Dinas Perindustrian dan Perdagangan',
                'alias' => 'Disperindag',
                'email' => 'disperindag@kotax.go.id',
                'alamat' => 'Jl. Niaga No. 20, Kota X',
                'telepon' => '081222334466',
            ],
            [
                'nama' => 'Dinas Perpustakaan dan Kearsipan',
                'alias' => 'Dispusip',
                'email' => 'dispusip@kotax.go.id',
                'alamat' => 'Jl. Buku No. 17, Kota X',
                'telepon' => '081344556677',
            ],
            [
                'nama' => 'Dinas Perumahan dan Kawasan Permukiman',
                'alias' => 'Disperkim',
                'email' => 'disperkim@kotax.go.id',
                'alamat' => 'Jl. Rumah No. 4, Kota X',
                'telepon' => '081466778899',
            ],
            [
                'nama' => 'Dinas Pemberdayaan Perempuan dan Perlindungan Anak',
                'alias' => 'DP3A',
                'email' => 'dp3a@kotax.go.id',
                'alamat' => 'Jl. Kartini No. 13, Kota X',
                'telepon' => '081599887744',
            ],
            [
                'nama' => 'Dinas Pemuda dan Olahraga',
                'alias' => 'Dispora',
                'email' => 'dispora@kotax.go.id',
                'alamat' => 'Jl. Atlet No. 21, Kota X',
                'telepon' => '081800112233',
            ],
            [
                'nama' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
                'alias' => 'DPMPTSP',
                'email' => 'dpmptsp@kotax.go.id',
                'alamat' => 'Jl. Investasi No. 15, Kota X',
                'telepon' => '081899776655',
            ],
            [
                'nama' => 'Dinas Pertanian dan Peternakan',
                'alias' => 'Dispertanak',
                'email' => 'dispertanak@kotax.go.id',
                'alamat' => 'Jl. Sawah No. 18, Kota X',
                'telepon' => '081988776655',
            ],
            [
                'nama' => 'Dinas Perikanan dan Kelautan',
                'alias' => 'Diskanlut',
                'email' => 'diskanlut@kotax.go.id',
                'alamat' => 'Jl. Laut No. 19, Kota X',
                'telepon' => '081977665544',
            ],
        ];

        foreach ($data as $item) {
            Institution::create([
                'nama' => $item['nama'],
                'pemerintah' => 'Pemerintah Kota',
                'telepon' => $item['telepon'],
                'email' => $item['email'],
                'alamat' => $item['alamat'],
                'alias' => $item['alias'],
                'kepala_instansi_id' => null,
            ]);
        }
    }
}
