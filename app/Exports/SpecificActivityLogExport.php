<?php

namespace App\Exports;

use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SpecificActivityLogExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithColumnWidths
{
    protected $assetId;

    public function __construct($assetId)
    {
        $this->assetId = $assetId;
    }

    public function collection()
    {
        return Activity::where('subject_type', 'App\\Models\\Asset')
            ->where('subject_id', $this->assetId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function map($activity): array
    {
        
        $changes = [];
        if (!empty($activity->changes)) {
            $attrs = $activity->changes['attributes'] ?? [];
            $old = $activity->changes['old'] ?? [];

            foreach ($attrs as $key => $newVal) {
                $oldVal = $old[$key] ?? '(kosong)';
                if ($oldVal !== $newVal) {
                    $changes[] = "{$key}: '{$oldVal}' → '{$newVal}'";
                }
            }
        }

        return [
            $activity->id,
            optional($activity->created_at)->format('Y-m-d H:i:s'),
            optional($activity->causer)->email ?? 'System',
            class_basename($activity->subject_type),
            $activity->subject_id,
            ucfirst($activity->event ?? '-'),
            $activity->description ?? '-',
            implode("\n", $changes) ?: '-', // multiline if multiple fields changed
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'User',
            'Model',
            'ID',
            'Event',
            'Deskripsi',
            'Perubahan',
        ];
    }

    public function title(): string
    {
        return 'Riwayat Aset';
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => '4F46E5'], // Indigo
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:H{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => 'top',
                'wrapText' => true, // wrap long changes
            ],
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 20,
            'C' => 30,
            'D' => 15,
            'E' => 8,
            'F' => 12,
            'G' => 50,
            'H' => 50,
        ];
    }
}
