<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionPdf extends Model
{       protected $table = 'soumissions_pdf';

    use HasFactory;
    protected $fillable = [
        'form_id',
        'user_id',
        'acteur_id',
        'pdf',
        'type',
        'periodicity',
        'year'
    ];
    public function form()
    {
        return $this->belongsTo('App\Models\FormPdf');
    }
}
