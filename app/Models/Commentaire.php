<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    protected $fillable =[
        'comment',
        'type',
        'submission_id',
    ];
    public function submission()
    {
        return $this->belongsTo('App\Models\Submission');
    }
}
