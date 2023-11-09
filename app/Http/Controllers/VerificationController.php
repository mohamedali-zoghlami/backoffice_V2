<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\validation_time;

class VerificationController extends Controller
{


    public function getThreeMonths(Request $request){
        $form_id=$request->form_id;
            $acteur=$request->acteur;
            $period=$request->periodicite;
            $year=$request->year;
            $lastMonths=[];
            for($i=0;$i<3;$i++)
            {
                if($period[0]==="A")
                    --$year;
                else
                    {
                        $pattern = '/^(M|TR|S)([1-9]|1[0-2])$/';
                        if (preg_match($pattern, $period, $matches)) {
                            $letter = $matches[1];
                            $number = intval($matches[2]);
                            if($number==1)
                                {
                                    if($letter=="M")
                                        $number=12;
                                    else if($letter=="TR")
                                        $number=4;
                                    else
                                        $number=2;
                                  --$year;
                                }
                            else
                            {
                                --$number;
                            }
                        $period=$letter.$number;
                    }
                    }
                $lastMonth=DB::table("soumissions")->where("form_id",$form_id)->where("operateur_id",$acteur)->where("periodicity",$period)->where("year",$year)->first();
                $lastMonths[]=$lastMonth;
            }
            return response()->json(["lastMonth"=>$lastMonths]);
    }
}
