<?php
namespace App\Exports;

use App\Models\Acteur;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class UserExport implements FromQuery, WithMapping,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return User::on("mysql")->where('role', 3);
    }

    public function map($user): array
    {   $acteur = Acteur::find($user->operateur_id);
        return [
            $user->name,
            $user->email,
           $acteur ? $acteur->nom_acteur : null,
        ];
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Email',
            'Nom opérateur'
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
