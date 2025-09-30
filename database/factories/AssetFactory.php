<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition()
    {
        return [
            'kode'             => strtoupper(Str::random(8)),
            'nama_aset'        => $this->faker->words(2, true),
            'jenis_aset'       => $this->faker->randomElement(['bergerak', 'tidak_bergerak', 'habis_pakai']),
            'category_id'      => Category::factory(), // auto-create a category
            'jumlah'           => $this->faker->numberBetween(1, 100),
            'tgl_pembelian'    => $this->faker->date(),
            'nilai_pembelian'  => $this->faker->randomFloat(2, 100000, 10000000),
            'lokasi_terakhir'  => $this->faker->city,
            'status'           => $this->faker->randomElement(['tersedia', 'dipakai', 'rusak', 'hilang', 'habis']),
            'departement_id'   => Departement::factory(), // auto-create a category
        ];
    }
}
