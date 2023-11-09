<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acteur;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Dashboard;
use App\Models\Fiche;
use App\Models\FormSave;
use App\Models\FormIntern;
use App\Models\Formule;
use App\Models\validation_time;

use App\Models\FormExcel;
use App\Models\User;
use App\Models\Groupe;
use App\Models\submission;
use App\Models\SubmissionExcel;
use App\Models\SubmissionIntern;
use App\Models\Domaine;
use App\Exports\ActeurExport;
use App\Exports\UserExport;
use App\Exports\AdminExport;
use App\Exports\DomaineExport;
use App\Exports\DashboardExport;
use App\Exports\FicheExport;
use App\Exports\FormulaireExport;
use App\Exports\GroupeExport;
use App\Exports\GroupeDetailExport;
use App\Exports\FormuleExport;
use App\Exports\PeriodiciteExport;

use Maatwebsite\Excel\Facades\Excel;


class exportPdfExcel extends Controller
{
public function exportToPDF(Request $request)
{   if($request->source==="acteurs")
        {$data=Acteur::on('mysql')->with('domaines')->get();
        $page="pdf.acteurs";}
    else if($request->source==="user")
       { $data=User::on("mysql")->where("role",3)->get();
        foreach($data as $user)
        {   $acteur=Acteur::on("mysql")->where("id",$user->operateur_id)->first();
            if($acteur)
            $user->operateur_name=$acteur->nom_acteur;
        }
        $page="pdf.user";}
    else if($request->source==="admin")
        {$data=User::on("sqlsrv")->where("role","!=",3)->get();
            $page="pdf.admin";}
    else if($request->source==="domaines")
       { $data=Domaine::on("mysql")->get();
        $page="pdf.domaines";}
    else if ($request->source==="dashboard")
       { $data=Dashboard::on("sqlsrv")->get();
        $page="pdf.dashboard";}
    else if($request->source==="groupes")
    {
        $data=Groupe::on("mysql")->get();
        $page="pdf.groupes";
    }
    else if($request->source==="groupesdetails")
    {
        $groupes=Groupe::on("mysql")->find($request->id);
        if($groupes)
        {
        $data= $groupes->forms()->orderBy('priorite')->get();
        $data->name=$groupes->name;
        $page="pdf.groupesdetails";
         }
    }
    else if ($request->source==="fiches")
        {$data=Fiche::on("mysql")->get();
        foreach($data as $fiche)
        {
            $operateur=$fiche->operateur;
            $operateur=str_replace('"', '', $operateur);
            $operateur= json_decode($operateur);
            $operateur = array_map('intval', $operateur);
            $fiche->operateur=Acteur::on('mysql')->whereIn("id",$operateur)->pluck('nom_acteur','id');
        }
            $page="pdf.fiches";
        }
    else if($request->source==="formules")
    {
        $data=Formule::on("mysql")->get();
        foreach($data as $formule)
        {
            $formule->name=FormSave::on("mysql")->where("id",$formule->form_id)->first()->name;
            $formule->acteur=Acteur::on("mysql")->where("id",$formule->operateur_id)->first()->nom_acteur;
        }
        $page="pdf.formules";
    }
    else if($request->source==="periodicite")
    {$data=validation_time::on("mysql")->get();
        $page="pdf.periodicite";
    }
    else if($request->id)
    {   $file=Fiche::on("mysql")->where("id",$request->id)->first();
        if($file)
            {
                $data=new \stdClass();
                $data->name=$file->name;
                $data->formulaire=FormSave::on("mysql")->where("fiche_id",$request->id)->get();
                $data->fichier=FormExcel::on("mysql")->where("fiche_id",$request->id)->get();
                $data->intern=FormIntern::on("sqlsrv")->where("fiche_id",$request->id)->get();
                $page="pdf.formulaires";
             }
        $pdf = Pdf::loadView($page, compact('data'));
        return $pdf->download($file->name.".pdf");
    }
    if(isset($page))
    {$pdf = Pdf::loadView($page, compact('data'));
    return $pdf->download($request->source.".pdf");}
    else
    return redirect()->back();
}

public function exportToExcel(Request $request)
{
    if($request->source==="acteurs")
        {return Excel::download(new ActeurExport, 'acteurs.xlsx');}
    else if($request->source==="user")
        {return Excel::download(new UserExport, 'utilisateurs.xlsx');}
        else if($request->source==="admin")
        {
            return Excel::download(new AdminExport,"administrateurs.xlsx");
        }
    else if($request->source==="domaines")
    {
        return Excel::download(new DomaineExport,"domaines.xlsx");
    }
    else if ($request->source==="dashboard")
       { return Excel::download(new DashboardExport,"dashboard.xlsx");
    }
    else if($request->source==="groupes")
    {
        return Excel::download(new GroupeExport,"groupes.xlsx");
    }
    else if($request->source==="groupesdetails")
    {
        return Excel::download(new GroupeDetailExport($request->id),"groupes_details.xlsx" );
    }
    else if ($request->source==="fiches")
        {
            return Excel::download(new FicheExport,"fiche.xlsx");
        }

    else if($request->source==="formules")
    {
        return Excel::download(new FormuleExport,"formules.xlsx");

    }
    else if($request->source==="periodicite")
    {
        return Excel::download(new PeriodiciteExport,"periodicite.xlsx");

    }
    else if($request->id)
    {   $file=Fiche::on("mysql")->where("id",$request->id)->first();
        if($file)
            {
            return Excel::download(new FormulaireExport($request->id),$file->name.".xlsx");
        }
    }
}

}
