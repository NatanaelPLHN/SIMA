<?php

namespace Database\Factories;

use App\Models\AsetTidakBergerak;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsetTidakBergerakFactory extends Factory
{
    protected $model = AsetTidakBergerak::class;

    public function definition()
    {
        return [
            'aset_id'      => Asset::factory(),
            'ukuran'       => $this->faker->randomElement(['10x20 m', '50x100 m', '200 m²']),
            'bahan'        => $this->faker->randomElement(['beton', 'baja', 'kayu']),
            'qr_code_path' => 'qrcodes/' . $this->faker->uuid . '.png',
        ];
    }
}
