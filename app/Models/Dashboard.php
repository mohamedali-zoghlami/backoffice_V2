<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{   protected $table="Dashboards";
    protected $connection="sqlsrv";
    use HasFactory;
    protected $fillable =[
        'name',
        'lien',
        'visible',
    ];
}
