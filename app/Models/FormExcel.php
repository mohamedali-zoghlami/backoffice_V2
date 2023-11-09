<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormExcel extends Model
{   protected $table = 'form_excels';
    use HasFactory;
    protected $fillable = [
        'excel',
        'user_id',
        'name',
        'mime',
        'visibility',
        'fiche_id',
        'periodicite',

    ];
    public function submissions()
    {
        return $this->hasMany('App\Models\SubmissionExcel');
    }
}
