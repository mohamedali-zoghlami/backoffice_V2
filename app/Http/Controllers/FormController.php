<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\SoumissionFaite;
use App\Models\validation_time;
use App\Models\submission;
use App\Models\FormSave;
use App\Models\Role;

class FormController extends Controller
{
    public function saveForm(Request $request)
    {  if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
         $user_id = $request->acteur;
        $validation=new HomeController();
        $data=new \stdClass();
        $data->acteur_name=auth()->user()->name;
        $data->name=FormSave::find($request->form_id)->name;
        if($request->has("periodicity"))
        {
            $sub=submission::where("operateur_id",$user_id)->where("form_id",$request->form_id)->where("periodicity",$request->periodicity)->where("year",$request->year)->first();
        }
        else
        {
        $sub=submission::where("operateur_id",$user_id)->where("form_id",$request->form_id)->where("periodicity",$request->periodicite,"mysql")->where("year",$request->year)->first();
        }
        if(!$sub)
        {
           DB::table('soumissions')->insert([
            ['form_id' => $request->form_id,
            'formHistoric_id' => $request->formHistoric_id,
            'user_id' => 1,
            'formJson'=>$request->dataJson,
            'type'=>$request->type,
            'historique'=>$request->historique,
            'operateur_id'=>$request->acteur,
            'year' => $request->year,
            'periodicity'=>$request->periodicite,
            'created_at'=>date('Y-m-d H:i:s'),
            'ESTIMATED'=>"A"],

        ]);
        }
        else
        {   if($request->type==="draft"||$sub->type==="draft")
                {
                $sub->timestamps = false;
                $sub->updated_at=null;
                }
            $sub->formJson=$request->dataJson;
            $sub->type=$request->type;
            $sub->ESTIMATED="A";
            $sub->save();
            $sub->timestamps = true;
            $data->periodicite=$sub->periodicity." - ".$sub->year;
        }
        if($request->type==="draft")
            return response()->json(["draft"=>"Brouillon sauvgarder"]);
        else
            return response()->json(["final"=>"Soumissions faites avec succées !"]);
    }
}
