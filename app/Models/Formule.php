<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formule extends Model
{
    use HasFactory;
    protected $fillable =[
        'operateur_id',
        'form_id',
        'pourcentage',
    ];
}
