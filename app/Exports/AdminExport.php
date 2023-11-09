<?php
namespace App\Exports;


use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class AdminExport implements FromQuery, WithMapping,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return User::on("sqlsrv")->where('role',"!=", 3);
    }

    public function map($user): array
    {   $role = $user->role==2?"Admin":"Super Admin";
        return [
            $user->name,
            $user->email,
           $role,
        ];
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Email',
            'Role'
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
