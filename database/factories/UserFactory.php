<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $roles = ['superadmin', 'admin', 'user'];

        return [
            'email'       => $this->faker->unique()->safeEmail(),
            'password'    => Hash::make('password'), // default password
            'role'        => $this->faker->randomElement($roles),
            'karyawan_id' => Employee::factory(),
        ];
    }
}
