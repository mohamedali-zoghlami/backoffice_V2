<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'path',
        'description',
        'user_id',
        'fiche_id',
        'visibilite',
        'section',
        'periodicite'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function fiche()
    {
        return $this->belongsTo('App\Models\Fiche');
    }
}
