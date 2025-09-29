<?php

namespace Database\Factories;

use App\Models\AsetBergerak;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsetBergerakFactory extends Factory
{
    protected $model = AsetBergerak::class;

    public function definition()
    {
        return [
            'aset_id'       => Asset::factory(),
            'merk'          => $this->faker->company,
            'tipe'          => $this->faker->word,
            'nomor_serial'  => strtoupper($this->faker->bothify('SN-#####')),
            'tahun_produksi'=> $this->faker->year,
            'qr_code_path'  => 'qrcodes/' . $this->faker->uuid . '.png',
        ];
    }
}
