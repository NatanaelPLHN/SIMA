<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'nip'          => $this->faker->unique()->numerify('EMP###'),
            'nama'         => $this->faker->name(),
            'alamat'       => $this->faker->address(),
            'telepon'      => $this->faker->phoneNumber(),
            'department_id'=> Departement::factory(),
        ];
    }
}
