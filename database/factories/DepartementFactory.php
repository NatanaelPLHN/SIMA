<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Institution;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departement>
 */
class DepartementFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true) . ' Department';

        return [
            'nama' => $name,
            'lokasi' => $this->faker->city(),
            'instansi_id' => Institution::factory(),
            // use both slug + random string to avoid duplicates
            'alias' => Str::slug($name) . '-' . Str::random(5),
        ];
    }
}
