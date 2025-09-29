<?php

namespace Database\Factories;

use App\Models\AsetHabisPakai;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsetHabisPakaiFactory extends Factory
{
    protected $model = AsetHabisPakai::class;

    public function definition()
    {
        return [
            'aset_id'  => Asset::factory(),
            'register' => strtoupper($this->faker->bothify('REG-#####')),
            'satuan'   => $this->faker->randomElement(['pcs', 'box', 'liter']),
        ];
    }
}
