<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class submissionIntern extends Model
{   protected $table="submissions_intern";
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

    public function form()
    {
        return $this->belongsTo('App\Models\FormIntern');
    }

}
