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

use App\Models\Borrowing;

class BorrowingLogExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    public function collection()
    {
        $user = Auth::user();
        $query = Activity::query()
            ->where('subject_type', Borrowing::class);

        // === ROLE-BASED FILTERING ===
        if ($user->role === 'admin') {
            $institutionId = $user->employee?->institution_id;
            if ($institutionId) {
                // Filter borrowing where the related asset’s department belongs to the admin’s institution
                $query->whereHasMorph('subject', [Borrowing::class], function ($borrowingQuery) use ($institutionId) {
                    $borrowingQuery->whereHas('asset.departement', function ($deptQuery) use ($institutionId) {
                        $deptQuery->where('instansi_id', $institutionId);
                    });
                });
            } else {
                return collect();
            }
        } elseif ($user->role === 'subadmin') {
            $departmentId = $user->employee?->department_id;
            if ($departmentId) {
                $query->whereHasMorph('subject', [Borrowing::class], function ($borrowingQuery) use ($departmentId) {
                    $borrowingQuery->whereHas('asset', function ($assetQuery) use ($departmentId) {
                        $assetQuery->where('department_id', $departmentId);
                    });
                });
            } else {
                return collect();
            }
        }

        return $query->latest()->get();
    }

    public function map($activitylog): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $activitylog->log_name,
            $activitylog->description,
            optional($activitylog->causer)->name ?? '-',
            $activitylog->event,
            $activitylog->subject_id,
            $activitylog->created_at?->format('Y-m-d H:i:s'),
            json_encode($activitylog->properties),
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Log Name',
            'Description',
            'Causer',
            'Event',
            'Borrowing ID',
            'Created At',
            'Properties',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = 'H'; // 8 columns

        // Header styling
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '1E40AF'],
                ],
            ],
        ]);

        // Auto width
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Center No column
        $sheet->getStyle('A2:A' . $highestRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Light border
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
        ]);

        // Zebra stripe
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 === 0) {
                $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->getFill()->applyFromArray([
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'F3F4F6'],
                ]);
            }
        }

        $sheet->freezePane('A2');

        return [];
    }
}
