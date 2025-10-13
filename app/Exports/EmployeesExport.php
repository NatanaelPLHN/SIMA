<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function collection()
    {
        return $this->employees;
    }

    // Map each employee to desired columns
    public function map($employee): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $employee->nip,
            $employee->nama,
            optional($employee->institution)->nama ?? '-',
            optional($employee->department)->nama ?? '-',
            $employee->alamat ?? '-',
            $employee->telepon ?? '-',
            $employee->created_at ? $employee->created_at->format('d-m-Y') : '-',
        ];
    }

    // header file excel
    public function headings(): array
    {
        return [
            'No',
            'NIP',
            'Name',
            'Institusi',
            'Bidang',
            'Alamat',
            'No Telepon',
            'Created At',
        ];
    }

    // Styling file excel
    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => '2563EB'], // Tailwind blue-600
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Auto width for all columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Center alignment for number column
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');

        // Light borders
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        return [];
    }
}
