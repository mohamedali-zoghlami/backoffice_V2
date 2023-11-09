<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\GroupeForm;
use App\Models\FormSave;
class verifyFormController extends Controller
{   public function id($sub)
    {
        $id=$sub->form_id;
        $form=GroupeForm::where("form_save_id",$id)->first();
        if(!$form)
            return null;

        if($form->priorite===1)
            return null;

        $form1=GroupeForm::where("groupe_id",$form->groupe_id)->where("priorite",$form->priorite-1)->first();
        if(!$form1)
            return null;
        return $form1->form_save_id;
    }

    public function groupe($sub)
    {   $period=[];
        $id=$sub->form_id;
        $periodicty=$sub->periodicity;
        $form=GroupeForm::where("form_save_id",$id)->first();
        if(!$form)
            return $period;

        if($form->priorite===1)
            return $period;

        $form1=GroupeForm::where("groupe_id",$form->groupe_id)->where("priorite",$form->priorite-1)->first();
        if(!$form1)
            return $period;

        $form=FormSave::find($id);
        $form1=FormSave::find($form1->form_save_id);
        if(!$form || !$form1)
            return $period;
        if($form->periodicite===$form1->periodicite)
            $period[]=$periodicty." - ".$sub->year;
        else
            $period=$this->period($periodicty,$sub->year,$form1->periodicite);
        return $period;

    }

    function period($periodicty,$year,$b)
    {
        $pattern = '/^(M|TR|S)([1-9]|1[0-2])$/';
        if (preg_match($pattern, $periodicty, $matches)) {
            $letter = $matches[1];
            $number = intval($matches[2]);
        }
        else
        {   $letter="A";
            $number=date("Y")-1;
        }
        if($letter==="M")
            {
                if($b==="annuelle")
                    return ["A - ".$year-1];
                else if($b==="trimestrielle")
                    {
                        $number-=1;
                        $number=(int)($number/3);
                        if($number===0)
                            {$number=4;
                            $year-=1;}
                        return ["TR".$number." - ".$year];
                    }
                else if($b==="semestrielle")
                {
                    $number-=1;
                    $number=(int)($number/6);
                    if($number===0)
                        {$number=2;
                        $year-=1;}
                    return ["S".$number." - ".$year];
                }
            }
        else if($letter==="TR")
        {
            if($b==="annuelle")
                return ["A - ".$year-1];
            else if($b==="semestrielle")
                {
                    $number-=1;
                    $number=(int)($number/2);
                    if($number===0)
                        {$number=2;
                        $year-=1;}
                    return ["S".$number." - ".$year];
                }
            else
            {
                switch($number)
                {
                    case 1:
                        return["M1- ".$year,"M2 - ".$year,"M3 - ".$year];
                    case 2:
                        return["M4 - ".$year,"M5 - ".$year,"M6 - ".$year];
                    case 3:
                        return["M7 - ".$year,"M8 - ".$year,"M9 - ".$year];
                    case 4:
                        return["M10 - ".$year,"M11 - ".$year,"M12 - ".$year];
                }
            }
        }
        else if($letter==="S")
        {
            if($b==="annuelle")
                return ["A - ".$year-1];
            else if($b==="trimestrielle")
            {
                switch($number)
                {
                    case 1:
                        return["TR1- ".$year,"TR2 - ".$year];
                    case 2:
                        return["TR3 - ".$year,"TR4 - ".$year];
                }
            }
            else
            {   $a=[];
                switch($number)
                {
                    case 1:
                        for($i=1;$i<7;$i++)
                            $a[]="M".$i." - ".$year;
                    case 2:
                        for($i=7;$i<13;$i++)
                            $a[]="M".$i." - ".$year;
                    return $a;
                }
            }
        }
        else
        {
            if($b==="mensuelle")
                {$less="M";
                    $num=12;}
                else if($b==="trimestrielle")
                {
                    $less="TR";
                    $num=4;
                }
                else
                {
                    $less="S";
                    $num=2;
                }
            $a=[];
            for($i=$num;$i>=1;$i++)
                $a[]=$less.$num." - ".$year;
            return $a;
        }

    }
}
