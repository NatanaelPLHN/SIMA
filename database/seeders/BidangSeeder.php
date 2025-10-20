<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        $bidangData = [
            // 1. Dinas Pendidikan
            ['Pendidikan Dasar', 'Gedung A Lt.1', 'BiDas'],
            ['Pendidikan Menengah', 'Gedung A Lt.2', 'BiMen'],
            ['Pendidikan Tinggi', 'Gedung A Lt.3', 'BiTing'],
            ['Kurikulum dan Evaluasi', 'Gedung A Lt.4', 'BiKurEv'],
            ['Tenaga Pendidik', 'Gedung A Lt.5', 'BiTen'],
            ['Penilaian dan Akreditasi', 'Gedung A Lt.6', 'BiAkre'],
            ['Sarana dan Prasarana', 'Gedung A Lt.7', 'BiSarpras'],
            ['Kesiswaan', 'Gedung A Lt.8', 'BiSiswa'],
            ['PAUD dan Dikmas', 'Gedung A Lt.9', 'BiPAUD'],
            ['Perencanaan dan Keuangan', 'Gedung A Lt.10', 'BiRenk'],
            
            // 2. Dinas Kesehatan
            ['Pelayanan Kesehatan', 'Gedung B Lt.1', 'BiKes'],
            ['Kesehatan Masyarakat', 'Gedung B Lt.2', 'BiKesMas'],
            ['Pencegahan Penyakit', 'Gedung B Lt.3', 'BiCegah'],
            ['Gizi dan Kesehatan Ibu Anak', 'Gedung B Lt.4', 'BiGizi'],
            ['Farmasi dan Alkes', 'Gedung B Lt.5', 'BiFarm'],
            ['Manajemen Rumah Sakit', 'Gedung B Lt.6', 'BiRS'],
            ['Kesehatan Lingkungan', 'Gedung B Lt.7', 'BiKesLing'],
            ['Kedaruratan dan Bencana', 'Gedung B Lt.8', 'BiDar'],
            ['Pengawasan Obat dan Makanan', 'Gedung B Lt.9', 'BiPOM'],
            ['Perencanaan dan Keuangan', 'Gedung B Lt.10', 'BiRenk'],

            // 3. Dinas Sosial
            ['Perlindungan Sosial', 'Gedung C Lt.1', 'BiLind'],
            ['Rehabilitasi Sosial', 'Gedung C Lt.2', 'BiRehab'],
            ['Pemberdayaan Sosial', 'Gedung C Lt.3', 'BiDay'],
            ['Penanganan Fakir Miskin', 'Gedung C Lt.4', 'BiFM'],
            ['Anak dan Lansia', 'Gedung C Lt.5', 'BiAnLan'],
            ['Kelembagaan Sosial', 'Gedung C Lt.6', 'BiLemb'],
            ['Bantuan Sosial', 'Gedung C Lt.7', 'BiBansos'],
            ['Psikososial', 'Gedung C Lt.8', 'BiPsiko'],
            ['Pemberdayaan Disabilitas', 'Gedung C Lt.9', 'BiDis'],
            ['Perencanaan dan Keuangan', 'Gedung C Lt.10', 'BiRenk'],

            // 4. Dinas Perhubungan
            ['Transportasi Darat', 'Gedung D Lt.1', 'BiTransDar'],
            ['Transportasi Laut', 'Gedung D Lt.2', 'BiTransLaut'],
            ['Transportasi Udara', 'Gedung D Lt.3', 'BiTransUd'],
            ['Keselamatan Transportasi', 'Gedung D Lt.4', 'BiSelam'],
            ['Angkutan Umum', 'Gedung D Lt.5', 'BiAngUm'],
            ['Terminal dan Parkir', 'Gedung D Lt.6', 'BiTerm'],
            ['Rekayasa Lalu Lintas', 'Gedung D Lt.7', 'BiReka'],
            ['Pengawasan dan Pengendalian', 'Gedung D Lt.8', 'BiWasdal'],
            ['Perhubungan Darat dan Laut', 'Gedung D Lt.9', 'BiHubDarLaut'],
            ['Perencanaan dan Keuangan', 'Gedung D Lt.10', 'BiRenk'],
        ];

        $instansiCount = 20;
        $perInstansi = 10;
        $currentIndex = 0;

        for ($instansi = 1; $instansi <= $instansiCount; $instansi++) {
            for ($i = 0; $i < $perInstansi; $i++) {
                // Jika habis daftar, ulang dari awal (agar 20 instansi tetap punya bidang)
                $data = $bidangData[$currentIndex % count($bidangData)];

                Departement::create([
                    'nama' => 'Bidang ' . $data[0],
                    'kepala_bidang_id' => null,
                    'lokasi' => $data[1],
                    'instansi_id' => $instansi,
                    'alias' => $data[2] . $instansi,
                ]);

                $currentIndex++;
            }
        }
    }
}
