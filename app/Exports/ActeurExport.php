<?php
namespace App\Exports;

use App\Models\Acteur;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ActeurExport implements FromQuery, WithMapping,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Acteur::on('mysql')->with('domaines');
    }

    public function map($acteur): array
    {
        return [
            $acteur->nom_acteur,
            $this->getDomaineNames($acteur),
        ];
    }

    protected function getDomaineNames($acteur)
    {
        $domaineNames = [];

        foreach ($acteur->domaines as $domaine) {
            $domaineNames[] = $domaine->nom_domaine;
        }

        return implode(' | ', $domaineNames);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Domaines',
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
