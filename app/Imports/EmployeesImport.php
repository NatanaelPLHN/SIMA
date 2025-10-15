<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Departement;
use App\Models\Institution;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class EmployeesImport implements ToModel, WithHeadingRow, SkipsOnFailure, SkipsEmptyRows
{
    use Importable, SkipsFailures;

    // store skipped duplicates for later summary
    protected array $skippedDuplicates = [];

    public function model(array $row)
    {
        // normalize headers
        $nip       = $row['nip'] ?? $row['NIP'] ?? null;
        $nama      = $row['nama'] ?? $row['Nama'] ?? $row['Name'] ?? null;
        $alamat    = $row['alamat'] ?? $row['Alamat'] ?? null;
        $telepon   = $row['telepon'] ?? $row['Telepon'] ?? $row['No Telepon'] ?? null;
        $institutionName = $row['instansi'] ?? $row['Institusi'] ?? $row['institution'] ?? null;
        $departementName = $row['bidang'] ?? $row['Bidang'] ?? $row['department'] ?? null;

        if (empty($nip) || empty($nama)) {
            return null;
        }

        // Resolve related models
        $institution = $institutionName ? Institution::where('nama', $institutionName)->first() : null;
        $departement = $departementName ? Departement::where('nama', $departementName)->first() : null;

        // check duplicates
        $existing = Employee::where('nip', $nip)->first();
        if ($existing) {
            $this->skippedDuplicates[] = [
                'nip' => $nip,
                'nama' => $existing->nama,
            ];

            return null;
        }

        return new Employee([
            'institution_id' => $institution?->id,
            'department_id'  => $departement?->id,
            'nip'            => $nip,
            'nama'           => $nama,
            'alamat'         => $alamat,
            'telepon'        => $telepon,
        ]);
    }

    public function getSkippedDuplicates(): array
    {
        return $this->skippedDuplicates;
    }
}
