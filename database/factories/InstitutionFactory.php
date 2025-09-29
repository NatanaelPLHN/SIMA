<?php

namespace Database\Factories;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstitutionFactory extends Factory
{
    protected $model = Institution::class;

    public function definition(): array
    {
        $name = $this->faker->company();

        return [
            'nama'       => $name,
            'pemerintah' => $this->faker->companySuffix(), // e.g. "Kementerian", "Dinas"
            'telepon'    => $this->faker->phoneNumber(),
            'email'      => $this->faker->unique()->companyEmail(),
            'alamat'     => $this->faker->address(),
            'alias'      => Str::slug($name),
        ];
    }
}
