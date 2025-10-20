<?php

namespace App\Exports;

use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Auth;

use App\Models\Asset;


class ActivityLogExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    public function collection()
    {
        $user = Auth::user();
        $query = Activity::query();

        // Hanya ambil log yang terkait dengan model Asset
        $query->where('subject_type', Asset::class);

        if ($user->role === 'admin') {
            $institutionId = $user->employee?->institution_id;
            if ($institutionId) {
                // Filter log dimana subject (Asset) memiliki departemen
                // yang berada di dalam instansi admin
                $query->whereHasMorph('subject', [Asset::class], function ($assetQuery) use ($institutionId) {
                    $assetQuery->whereHas('departement', function ($deptQuery) use ($institutionId) {
                        $deptQuery->where('instansi_id', $institutionId);
                    });
                });
            } else {
                // Jika admin tidak punya instansi, jangan tampilkan apa-apa
                return collect();
            }
        } elseif ($user->role === 'subadmin') {
            $departmentId = $user->employee?->department_id;
            if ($departmentId) {
                // Filter log dimana subject (Asset) memiliki department_id yang cocok
                $query->whereHasMorph('subject', [Asset::class], function ($assetQuery) use ($departmentId) {
                    $assetQuery->where('department_id', $departmentId);
                });
            } else {
                // Jika subadmin tidak punya departemen, jangan tampilkan apa-apa
                return collect();
            }
        }
        // Untuk superadmin, tidak ada filter tambahan, jadi dia akan mendapatkan semua log aset.

        return $query->get();
    }

    public function map($activitylog): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $activitylog->log_name,
            $activitylog->description,
            $activitylog->subject_type,
            $activitylog->event,
            $activitylog->subject_id,
            $activitylog->opname_id,
            $activitylog->causer_type,
            $activitylog->causer_id,
            $activitylog->properties,
            $activitylog->batch_uuid,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Log Name',
            'Description',
            'Subject Type',
            'Event',
            'Subject ID',
            'Causer Type',
            'Causer ID',
            'Properties',
            'Batch UUID',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = 'J'; // 10 column (a-j)

        // === HEADER STYLE ===
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '2563EB'], // Tailwind blue-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '1E40AF'], // Tailwind blue-800
                ],
            ],
        ]);

        // === AUTO WIDTH FOR ALL COLUMNS ===
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // === ALIGN "No" COLUMN CENTER ===
        $sheet->getStyle('A2:A' . $highestRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // === ADD LIGHT BORDER TO ALL CELLS ===
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
        ]);

        // === OPTIONAL: ZEBRA STRIPES FOR READABILITY ===
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 === 0) {
                $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->getFill()->applyFromArray([
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'F3F4F6'], // Tailwind gray-100
                ]);
            }
        }

        // === FREEZE HEADER ROW ===
        $sheet->freezePane('A2');

        return [];
    }
}
