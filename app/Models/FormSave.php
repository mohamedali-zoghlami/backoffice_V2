<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSave extends Model
{   protected $table = 'forms';
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
    public function submissions()
    {
        return $this->hasMany('App\Models\Submission');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function fiche()
    {
        return $this->belongsTo('App\Models\Fiche');
    }
    public function groups() {
        return $this->belongsToMany(Group::class, 'groupe_forms')->withPivot('priorite');
    }
}
