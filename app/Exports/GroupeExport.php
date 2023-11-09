<?php
namespace App\Exports;

use App\Models\Groupe;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class GroupeExport implements FromQuery, WithMapping,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;


    public function query()
    {
        return Groupe::on("mysql");
    }

    public function map($user): array
    {
        return [
            $user->nom,
        ];
    }

    public function headings(): array
    {
        return [
            'Nom',
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
