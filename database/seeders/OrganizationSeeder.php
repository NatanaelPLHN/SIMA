<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;
use App\Models\Departement;
use App\Models\Employee;
use App\Models\User;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create X institutions
        Institution::factory()
            ->count(2)
            ->has(
                Departement::factory()
                    ->count(3) // X departments per institution
                    ->has(
                        Employee::factory()
                            ->count(13) // X employees per department
                            ->has(User::factory()) // each employee has 1 user account
                    )
            )
            ->create()
            ->each(function ($institution) {
                // Assign a random "kepala" (head) to each department
                $institution->departements->each(function ($department) {
                    $kepala = $department->employees->random();
                    $department->kepala_bidang_id = $kepala->id;
                    $department->save();
                });
            });
    }
}
