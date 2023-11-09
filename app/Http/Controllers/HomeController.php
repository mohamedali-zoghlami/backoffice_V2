<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class HomeController extends Controller
{
    public static function time($form,$connection){
        $validation= new HomeController();
        $validation->mens=DB::connection($connection)->table('validation_time')->where("periodicite","mensuelle")->first();
        $validation->tri=DB::connection($connection)->table('validation_time')->where("periodicite","trimestrielle")->first();
        $validation->sem=DB::connection($connection)->table('validation_time')->where("periodicite","semestrielle")->first();
            if($form==="mensuelle")
                {

                    $month=Carbon::now()->subMonths($validation->mens->increment_start);
                    $day=Carbon::now()->format("d");
                    if($day==="31")
                    {
                        $month=$month->subDay();
                    }
                    $month=$month->format("m");
                    if($day<$validation->mens->start_day)
                        {
                            $carbonMonth = Carbon::createFromFormat('m', $month);
                            $carbonMonth->subMonth();
                            $updatedMonth = $carbonMonth->format('n');
                            $month = $updatedMonth;
                        }
                    $month=ltrim($month,"0");
                    return "M".$month;
                }
            else if($form==="trimestrielle")
            {   $val=$validation->tri->increment_start;
                $currentDate = Carbon::now();
                $t1_start=Carbon::create($currentDate->year, (3+$val)%12, $validation->tri->start_day);
                $t1_end=$t1_start->copy()->addMonths(3);
                $t2_start=Carbon::create($currentDate->year, (6+$val)%12, $validation->tri->start_day);
                $t2_end=$t2_start->copy()->addMonths(3);
                $t3_start=Carbon::create($currentDate->year, (9+$val)%12, $validation->tri->start_day);
                $t3_end=$t3_start->copy()->addMonths(3);
                if ($currentDate->between($t1_start, $t1_end)) {
                    // Display T1
                    return 'TR1';
                }
                else if($currentDate->between($t2_start, $t2_end))
                {
                   return 'TR2';
                }
                else if($currentDate->between($t3_start, $t3_end))
                {
                    return 'TR3';
                }
                else
                return 'TR4';
            }
            else if($form==="semestrielle")
            {   $val=$validation->sem->increment_start;
                $currentDate = Carbon::now();
                $s1_start=Carbon::create($currentDate->year, (6+$val)%12, $validation->sem->start_day);
                $s1_end=$s1_start->copy()->addMonths(6);
                if ($currentDate->between($s1_start, $s1_end)) {
                    // Display T1
                    return 'S1';
                }
                else
                {
                    return 'S2';
                }
            }
            else
                 return "A";
    }
    public static function year($validation_time)
    {   $currentYear=date("Y");
        $previousYear=$currentYear-1;
        if($validation_time==="M12"||$validation_time==="T4"||$validation_time==="S2"||$validation_time==="A")
            return $previousYear;
        return $currentYear;
    }
    public static function decreasePeriod($period)
    {
        preg_match('/([A-Za-z]+)(\d+)/', $period, $matches);
        $letter = $matches[1];
        $number = (int)$matches[2];
        $decreasedNumber = $number - 1;
        if($decreasedNumber===0)
            {
                if($letter[0]==="M")
                    $decreasedNumber=12;
                else if($letter[0]==="T")
                    $decreasedNumber=4;
                else if($letter[0]==="S")
                    $decreasedNumber=2;
            }
        return $letter . $decreasedNumber;

    }
}
