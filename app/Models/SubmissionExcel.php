<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionExcel extends Model
{
    use HasFactory;
    protected $table = 'soumissions_excels';
    protected $fillable = [
        'excel',
        'form_id',
       //'path',
        'user_id',
        'acteur_id',
        'type',
        'historique',
        'year',
        'periodicity',
        'mime',
    ];
    public function Commentaires()
    {
        return $this->hasMany('App\Models\CommentaireExcel');
    }
    public function form()
    {
        return $this->belongsTo('App\Models\FormExcel');
    }
}
