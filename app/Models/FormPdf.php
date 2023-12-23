<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPdf extends Model
{   protected $table = 'form_pdf';
    use HasFactory;
    protected $fillable = [
        'description',
        'periodicite',
        'name',
        'fiche_id',
    ];
}
