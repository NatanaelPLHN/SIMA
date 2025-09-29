<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $name = ucfirst($this->faker->word()) . ' ' . $this->faker->unique()->numberBetween(1, 9999);

        return [
            'nama'              => $name,
            'deskripsi'         => $this->faker->sentence(),
            'category_group_id' => CategoryGroup::factory(),
            'alias'             => Str::slug($name),
        ];
    }
}
