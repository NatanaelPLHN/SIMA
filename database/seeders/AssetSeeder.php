<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\AsetBergerak;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $asset = Asset::create([
            'kode' => 'AST-001',
            'nama_aset' => 'Mobil Operasional',
            'jenis_aset' => 'bergerak',
            'kategori' => 'Kendaraan',
            'group_kategori' => 'Transportasi',
            'jumlah' => 2,
            'tgl_pembelian' => '2024-05-15',
            'nilai_pembelian' => 350000000,
            'lokasi_terakhir' => 'Kantor Pusat',
            'status' => 'dipakai',
        ]);

        AsetBergerak::create([
            'aset_id' => $asset->id,
            'merk' => 'Toyota',
            'tipe' => 'Avanza',
            'tahun_produksi' => '2024-05-15',
        ]);
    }
}
