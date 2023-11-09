<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormExcel;
use App\Models\SubmissionExcel;
use App\Models\Role;

class fileController extends Controller
{
    public function fileCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Rôle introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de faire des créations");

    }
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $base64Data = base64_encode(file_get_contents($file));
            $form= new FormExcel();
            $form->user_id=1;
            $form->excel=$base64Data;
            $form->fiche_id=$request->input("id");
            $form->name=$request->input("name");
            $form->visibility=$request->input("visibility");
            $form->periodicite=$request->input("periodicite");
            $form->mime=$file->getClientMimeType();
            $form->setConnection('mysql')->save();
            return redirect()->back()->with("success","Fichier ajouté avec succés !");
        }
    }
    public function fileUpdate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de faire des modifications");

    }
        $form = FormExcel::on("mysql")->find($request->input("idFile"));
        if(!$form)
        {
            return redirect()->back()->with("error","Fichier non trouvé !");
        }
        $sub=SubmissionExcel::on("mysql")->where("form_id",$request->input("idFile"))->first();
        if($sub)
        {
            return redirect()->back()->with("error","Fichier soumis ne peut pas être modifié !");
        }
        $form->name=$request->input("nameFile");
        $form->visibility=$request->input("visibilityFile");
        $form->periodicite=$request->input("periodiciteFile");
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $base64Data = base64_encode(file_get_contents($file));
            $form->mime=$file->getClientMimeType();
            $form->excel=$base64Data;
        }
        $form->setConnection('mysql')->save();
        return redirect()->back()->with("success","Fichier ajouté avec succés !");
    }
    public function download(Request $request)
    {
        if($request->has('id'))
            {   $download_url=route("file.download2",["id"=>$request->id,"type"=>$request->type]);
                return response()->json(['success' => true, 'download_url' => $download_url]);
            }
        else
            {   dd($request);
                return response()->json(['error' =>"Something went wrong !"]);
            }
    }

}
