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

class ActivityLogExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    public function collection()
    {
        return Activity::all();
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
