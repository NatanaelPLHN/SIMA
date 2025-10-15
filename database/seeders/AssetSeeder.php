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
        // Example 1: Aset Bergerak
        $asset1 = Asset::create([
            'kode'             => 'AST-0001',
            'nama_aset'        => 'Laptop Dell Inspiron',
            'jenis_aset'       => 'bergerak',
            'category_id'      => 1,
            'jumlah'           => 1,
            'tgl_pembelian'    => '2023-04-10',
            'nilai_pembelian'  => 15000000,
            'lokasi_terakhir'  => 'Ruang IT',
            'status'           => 'tersedia',
            'department_id'   => 1,
        ]);

        AsetBergerak::create([
            'aset_id'        => $asset1->id,
            'merk'           => 'Dell',
            'tipe'           => 'Inspiron 14',
            'nomor_serial'   => 'SN-12345A',
            'tahun_produksi' => 2023,
            'qr_code_path'   => 'qr_codes/bergerak/AST-0001.png',
        ]);

        // Example 2: Aset Tidak Bergerak
        $asset2 = Asset::create([
            'kode'             => 'AST-0002',
            'nama_aset'        => 'Meja Kantor Kayu',
            'jenis_aset'       => 'tidak_bergerak',
            'category_id'      => 2,
            'jumlah'           => 1,
            'tgl_pembelian'    => '2022-08-15',
            'nilai_pembelian'  => 3000000,
            'lokasi_terakhir'  => 'Ruang Administrasi',
            'status'           => 'tersedia',
            'department_id'   => 1,
        ]);

        AsetTidakBergerak::create([
            'aset_id'      => $asset2->id,
            'ukuran'       => '120x60 cm',
            'bahan'        => 'Kayu Jati',
            'qr_code_path' => 'qr_codes/tidak_bergerak/AST-0002.png',
        ]);

        // Example 3: Aset Habis Pakai
        $asset3 = Asset::create([
            'kode'             => 'AST-0003',
            'nama_aset'        => 'Tinta Printer Canon',
            'jenis_aset'       => 'habis_pakai',
            'category_id'      => 3,
            'jumlah'           => 50,
            'tgl_pembelian'    => '2024-01-05',
            'nilai_pembelian'  => 50000,
            'lokasi_terakhir'  => 'Gudang ATK',
            'status'           => 'tersedia',
            'department_id'   => 1,
        ]);

        AsetHabisPakai::create([
            'aset_id'  => $asset3->id,
            'register' => 'REG-001',
            'satuan'   => 'botol',
        ]);
    }
}
