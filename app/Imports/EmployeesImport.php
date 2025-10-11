<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Departement;
use App\Models\Institution;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $departement = Departement::where('nama', $row['bidang'])->first();
        $institution = Institution::where('nama', $row['instansi'])->first();

        return new Employee([
            'institution_id' => $institution ? $institution->id : null,
            'department_id' => $departement ? $departement->id : null,
            'nip'            => $row['nip'],
            'nama'           => $row['nama'],
            'alamat'         => $row['alamat'],
            'telepon'        => $row['telepon'],
        ]);
    }
}
