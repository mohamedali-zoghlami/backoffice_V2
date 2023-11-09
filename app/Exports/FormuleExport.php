<?php
namespace App\Exports;

use App\Models\Acteur;
use App\Models\Formule;
use App\Models\FormSave;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class FormuleExport implements FromQuery, WithMapping,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Formule::on('mysql');
    }

    public function map($acteur): array
    {   $name=FormSave::on("mysql")->where("id",$acteur->form_id)->first()->name;
        $act=Acteur::on("mysql")->where("id",$acteur->operateur_id)->first()->nom_acteur;
        return [
            $name,
            $act,
            $acteur->operation." ".$acteur->pourcentage."%"
        ];
    }

    public function headings(): array
    {
        return [
            'Formulaire',
            'Acteur',
            'Pourcentage'
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
