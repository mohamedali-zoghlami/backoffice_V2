<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentaireExcel extends Model
{
    use HasFactory;
    protected $table="commentaires_excels";
    protected $fillable =[
        'comment',
        'type',
        'submission_id',
    ];
    public function submission()
    {
        return $this->belongsTo('App\Models\SubmissionExcel');
    }
}
