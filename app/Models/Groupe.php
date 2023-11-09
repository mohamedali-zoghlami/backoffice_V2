<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    protected $connection="mysql";
    protected $fillable =[
        'nom',
        'priorite'
    ];

    public function forms() {
        return $this->belongsToMany(FormSave::class, 'groupe_forms')->withPivot('priorite');
    }
}
