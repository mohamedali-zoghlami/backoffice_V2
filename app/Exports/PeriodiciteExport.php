<?php
namespace App\Exports;


use App\Models\validation_time;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class PeriodiciteExport implements FromQuery, WithMapping,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return validation_time::on('mysql');
    }

    public function map($acteur): array
    {
        return [
            $acteur->periodicite,
            $acteur->start_day,
            "M+".$acteur->increment_start,
            $acteur->final_day,
            "M+".$acteur->increment_final
        ];
    }

    public function headings(): array
    {

        return [
            'Periodicite',
            'Jour de débu',
            'Mois de début',
            'Jour de fin',
            'Mois de fin'
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFFF00'], // Set your desired background color here
                ],
            ],
        ];
    }
}
