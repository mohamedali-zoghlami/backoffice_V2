<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentairePdf extends Model
{
    use HasFactory;
    protected $table="commentaires_pdf";
    protected $fillable =[
        'comment',
        'type',
        'submission_id',
    ];

}
