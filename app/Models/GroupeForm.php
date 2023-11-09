<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupeForm extends Model
{
    use HasFactory;
    protected $connection="mysql";
    protected $fillable =[
        'form_id',
        'group_id',
        'priorite'
    ];


}
