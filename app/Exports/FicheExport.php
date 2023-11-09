<?php
namespace App\Exports;

use App\Models\Acteur;
use App\Models\Fiche;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class FicheExport implements FromQuery, WithMapping,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Fiche::on("mysql");
    }

    public function map($user): array
    {   $operateur=$user->operateur;
        $operateur=str_replace('"', '', $operateur);
        $operateur= json_decode($operateur);
        $operateur = array_map('intval', $operateur);
        $opp=Acteur::on('mysql')->whereIn("id",$operateur)->pluck('nom_acteur');
        $opps=[];
        foreach($opp as $op)
            $opps[]=$op;
        $oppss=implode(' | ', $opps);
        return [
            $user->name,
           $oppss,
        ];
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Acteurs',
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
