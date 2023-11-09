<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmissionIntern;
use App\Models\Submission;
use App\Models\User;
use Carbon\Carbon;
class modificationController extends Controller
{
  public function check(Request $request)
  {
    $email=$request->email;
    $password=$request->password;
    if(!$email || !$password)
    {
        return response()->json(["error"=>"Email et mot de passe sont obligatoires !"]);
    }
    $user=User::on("sqlsrv")->where("email",$email)->first();
    if(!$user)
    {
        return response()->json(["error"=>"Veuillez vérifier vos cordonnées !"]);
    }
    if(!\Hash::check($request->password, $user->password)){
        return response()->json(['error'=>"Veuillez vérifier vos cordonnées !"]);
    }
    if($user->role!=="1")
    {
        return response()->json(['error'=>" Vous n'êtes pas autorisés de faire les modifications. Veuillez contacter votre super administrateur !"]);
    }
    return response()->json(["success"=>"authentifier"]);
  }
  public function update(Request $request)
  {
    $id=$request->id;
    $data=$request->data;
    $type=$request->type;
    if(!$id || !$data || !$type)
      return  response()->json(["error"=>"Erreur Inatendu !"]);
    if($type==="intern")
      $sub=SubmissionIntern::on("sqlsrv")->find($id);
    else
      $sub=submission::on("sqlsrv")->find($id);
    if(!$sub)
      return  response()->json(["error"=>"Soumission introuvable!"]);
    $sub->timestamps=false;
    $sub->updated_at=Carbon::now()->format('Ymd H:i:s');
    $sub->formJson=$data;
    $sub->setConnection("sqlsrv")->save();
    $sub->timestamps=true;
    return response()->json(["success"=>"Modification faite avec succès !"]);
  }
}
