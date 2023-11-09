<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiche extends Model
{   protected $table = 'fiches';
    use HasFactory;
    protected $fillable = [
        'name',
        'operateur',
        //'periodicite'
    ];

}
