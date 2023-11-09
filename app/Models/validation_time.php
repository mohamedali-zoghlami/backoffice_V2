<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class validation_time extends Model
{
    use HasFactory;
    protected $table="validation_time";
    protected $fillable = [
        'start_day',
        'increment_start',
        'final_day',
        'incremenet_final'
    ];


}
