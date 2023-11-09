<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'excel',
        'fiche_id',
        'file_id',
        'user_id',
        'operateur_id'
    ];


    public function fiche()
    {
        return $this->belongsTo('App\Models\Fiche');
    }
    public function fichier()
    {
        return $this->belongsTo('App\Models\Fichier');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function operateur()
    {
        return $this->belongsTo('App\Models\Operateur');
    }

}
