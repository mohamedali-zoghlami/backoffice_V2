<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class submission extends Model
{
    protected $table = 'soumissions';
	use HasFactory;
    protected $fillable = [
        'formJson',
        'form_id',
      //  'formHistoric_id',
        'user_id',
        'operateur_id',
        'historique',
        'year',
        'periodicity',
        'created_at',
        'updated_at'
    ];
    public function Commentaires()
    {
        return $this->hasMany('App\Models\Commentaire');
    }
    public function form()
    {
        return $this->belongsTo('App\Models\FormSave');
    }
    public function formHisto()
    {
        return $this->belongsTo('App\Models\FromHistoric');
    }
    public function operateur()
    {
        return $this->belongsTo('App\Models\Operateur');
    }
}
