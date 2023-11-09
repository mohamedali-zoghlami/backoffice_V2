<?php
namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class FormulaireExport implements WithMultipleSheets
{
    use Exportable;

   protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];

        // First Sheet
        $sheets[] = new FormulaireSheet("formulaire",$this->data);

        // Second Sheet
        $sheets[] = new FormulaireSheet("fichier",$this->data);

        $sheets[] = new FormulaireSheet("intern",$this->data);

        return $sheets;
    }
}
