<?php
namespace App\Exports;

use App\Models\FormExcel;
use App\Models\FormSave;
use App\Models\FormIntern;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class FormulaireSheet implements FromCollection,WithHeadings,WithStyles,ShouldAutoSize
{
    use Exportable;
    protected $type;
    protected $data;

    public function __construct($type,$data)
    {   $this->type=$type;
        $this->data = $data;
    }
    public function collection()
    {   if($this->type==="formulaire")
            return FormSave::on("mysql")->select('name', "periodicite")->where("fiche_id",$this->data)->get();
        else if($this->type==="fichier")
            return FormExcel::on("mysql")->select('name', "periodicite")->where("fiche_id",$this->data)->get();
        else
            return FormIntern::on("sqlsrv")->select('name', "periodicite")->where("fiche_id",$this->data)->get();
    }


    public function headings(): array
    {
        return [
            'Nom',
            'Périodicite',
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
