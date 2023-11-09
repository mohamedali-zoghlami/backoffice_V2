<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormIntern extends Model
{   protected $table = 'Form_Interne';
    use HasFactory;
    protected $fillable = [
        'formJson',
        'user_id',
        'name',
        'section',
        'visibility',
        'fiche_id',
        'periodicite'

    ];

}
