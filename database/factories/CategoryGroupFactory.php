<?php

namespace Database\Factories;

use App\Models\CategoryGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryGroupFactory extends Factory
{
    protected $model = CategoryGroup::class;

    public function definition()
    {
        // Always unique because of uniqid()
        $name = ucfirst($this->faker->word()) . ' ' . uniqid();

        return [
            'nama'      => $name,
            'deskripsi' => $this->faker->sentence(),
            'alias'     => Str::slug($name),
        ];
    }
}
