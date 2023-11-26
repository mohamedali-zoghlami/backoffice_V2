<?php

namespace App\Http\Controllers;
use App\Models\FormSave;
use App\Models\Groupe;
use App\Models\GroupeForm;
use App\Models\Commentaire;
use App\Models\CommentaireExcel;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\FormIntern;
use App\Models\FormExcel;
use App\Models\SystemTime;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Submission;
use App\Models\SubmissionIntern;
use App\Models\Role;

use App\Models\SubmissionExcel;
use App\Models\validation_time;
use App\Models\Parametre;
use App\Models\submissionTemp;
use App\Models\Acteur;
use App\Models\Domaine;
use App\Models\DomaineActeur;
use App\Models\Formule;
use Illuminate\Support\Facades\Mail;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Password;
use App\Models\Demande;
use App\Models\Fiche;
use App\Models\Fichier;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Mail\SendUser;
use Carbon\Carbon;
use App\Events\FicheCreated;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class adminController extends Controller
{

    //
    public function acteur(Request $request)
    {
        $acteur= Acteur::on('mysql')->with('domaines');
        if ($request->has('name'))
            $acteur->where("nom_acteur",'like', '%' . $request->name . '%');
        $acteurs=$acteur->paginate(10);
        if ($request->ajax()) {
            return view('pages.acteurpartial', compact('acteurs'))->render();
        }
        $domaines=Domaine::on('mysql')->orderBy('nom_domaine')->get();
        return view('pages.acteurs',['acteurs'=>$acteurs,'domaines'=>$domaines]);
    }


    public function acteurCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        $dbacteur = Acteur::on('mysql')->where('nom_acteur', $request->nom_acteur)->first();
        if($dbacteur){
            return redirect()->back()->with('error','Acteur déjà enregistré.');
        }else{

        $domaines = $request->input('choices', []);
        $acteur= new Acteur;
        $acteur->nom_acteur = $request->input('nom_acteur');
        $acteur->setConnection('mysql')->save();
        $acteur->setConnection('mysql')->domaines()->attach(array_map('intval', $domaines));
        }
        return redirect()->back()->with('success', 'Acteur enregisté avec succès');

    }

    public function acteurDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de supprimer!");

    }
        $id=$request->input("idActeur");
        if(!$id)
            return redirect()->back()->with('error','Aucun id!');
        $acteur=Acteur::on('mysql')->where("id",$id)->first();
        if(!$acteur)
            return redirect()->back()->with('error','Acteur introuvable !');
        $user=User::on('mysql')->where("operateur_id",$id)->first();
        if($user)
            return redirect()->back()->with('error','Acteur non supprimé : un utilisateur est assigné à cet acteur !');
        $acteur->setConnection('mysql')->delete();
        return redirect()->back()->with('success','Acteur supprimé !');
    }
    public function acteurUpdate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modifier !");

    }
        $id=$request->input("id");
        $name=$request->input("nom_acteur2");
        $choices=$request->input('choices2', []);
        $acteur = Acteur::on('mysql')->where('id', $id)->first();
        if(!$acteur)
            return redirect()->back()->with('error','Acteur introuvable !');
        $act=Acteur::on('mysql')->where('id','!=',$id)->where("nom_acteur",$name)->first();
        if($act)
         return redirect()->back()->with('error','Acteur déjà enregistré.');
        $acteur->nom_acteur=$name;
        $acteur->setConnection('mysql')->save();
        $acteur->setConnection('mysql')->domaines()->detach();
        $acteur->setConnection('mysql')->domaines()->attach(array_map('intval', $choices));
        return redirect()->back()->with('success','Acteur modifié !');
    }
    public function user(Request $request)
    {   $users=User::on("mysql")->where("role",3);
        if($request->has("name"))
            $users=$users->where("name",'like', '%' . $request->name . '%')->orWhere("email",'like', '%' . $request->name . '%');
        $users= $users->paginate(10);
        foreach($users as $user)
        {   $acteur=Acteur::on("mysql")->where("id",$user->operateur_id)->first();
            if($acteur)
            $user->operateur_name=$acteur->nom_acteur;
        }
        if ($request->ajax()) {
            return view('pages.userspartial', compact('users'))->render();
        }
        $operateur=Acteur::on('mysql')->orderBy("nom_acteur")->get();
        return view('pages.users',['users'=>$users,"operateurs"=>$operateur]);
    }
    public function userCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        $role=$request->input("role");
        $name=$request->input("name");
        $email=$request->input("email");
        $operateur=$request->input("operateur_id");
        $user = User::on('mysql')->where("email",$email)->first();
        if($user)
            return redirect()->back()->with('error','Email utilisé !');
        $user= new User();
        $user->name=$name;
        $user->email=$email;
        $user->role=$role;
        $user->operateur_id=$operateur;
        $token = Password::broker()->createToken($user);
        $opp="";
        $opp=Acteur::on('mysql')->where('id', $operateur)->first()->nom_acteur;
        $resetUrl= env("FRONT_OFFICE_WEB").route('password.reset', ['token' => $token, 'email' => urlencode($user->email)], false);
        Mail::to($user->email)->send(new AdminPasswordResetNotification($opp,$resetUrl));
        $user->setConnection('mysql')->save();
        return redirect()->back()->with('success','Utilisateur ajouté !');
    }
    public function userDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        $id=$request->input("idUser");
        if(!$id)
            return redirect()->back()->with('error','Aucun id!');
        $submission=submission::on('mysql')->where("user_id",$id)->first();
        if($submission)
            return redirect()->back()->with('error','Utilisateur non supprimé : a fait des soumissions !');
        $user=User::on('mysql')->where("id",$id)->first();
        if(!$user)
            return redirect()->back()->with('error','Utilisateur introuvable !');
        $user->setConnection('mysql')->delete();
        return redirect()->back()->with('success','Utilisateur supprimé !');

    }
    public function userUpdate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modifier !");

    }
        $id=$request->input("id");
        $role=$request->input("role");
        $name=$request->input("name");
        $email=$request->input("email");
        $operateur=$request->input("operateur_id");
        $user=User::on('mysql')->where("email",$email)->where("id","!=",$id)->first();
        if($user)
            return redirect()->back()->with('error','Email utilisé !');
        $user=User::on('mysql')->where("id",$id)->first();
        if(!$user)
            return redirect()->back()->with('error','Utilisateur introuvable !');
        $user->name=$name;
        $user->email=$email;
        $user->role=$role;
        $user->operateur_id=$operateur;
        $user->setConnection('mysql')->save();
        return redirect()->back()->with('success','Utilisateur modifié !');
    }

    public function domaine(Request $request)
    {
        if($request->has("name"))
            $domaines=Domaine::on('mysql')->where("nom_domaine",'like', '%' . $request->name . '%')->paginate(10);
        else
            $domaines= Domaine::on('mysql')->paginate(10);
        if ($request->ajax())
            return view('pages.domainespartial', compact('domaines'))->render();

        return view('pages.domaines',['domaines'=>$domaines,]);
    }
    public function domaineCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        $name=$request->input("name");
        $domaine=Domaine::on('mysql')->where("nom_domaine",$name)->first();
        if($domaine)
            return redirect()->back()->with('error','Domaine existe déja !');
        $domaine=new Domaine();
        $domaine->nom_domaine=$name;
        $domaine->setConnection('mysql')->save();
        return redirect()->back()->with('success','Domaine ajouté !');
    }
    public function domaineDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        $id=$request->input("idDomaine");
        $domaine=Domaine::on('mysql')->where("id",$id)->first();
        if(!$domaine)
            return redirect()->back()->with('error','Domaine inexistant !');
        $acteur=DomaineActeur::on('mysql')->where("domaine_id",$id)->first();
        if($acteur)
            return redirect()->back()->with('error','Domaine assigné à un acteur !');
        $domaine->setConnection('mysql')->delete();
        return redirect()->back()->with('success','Domaine supprmié !');
    }
    public function domaineUpdate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        $id=$request->input("id");
        $name=$request->input("name");
        $domaine=Domaine::on('mysql')->where("nom_domaine",$name)->first();
        if($domaine)
             return redirect()->back()->with('error','Nom domaine existant !');
        $domaine=Domaine::on('mysql')->where("id",$id)->first();
        $domaine->nom_domaine=$name;
        $domaine->setConnection('mysql')->save();
        return redirect()->back()->with('success','Domaine modifié !');
    }
    public function fiche(Request $request)
    {   $fiches=Fiche::on('mysql');
        if($request->has("name"))
            $fiches=$fiches->where("name",'like', '%' . $request->name . '%');
        if(!empty($request->operateur_id))
        {    if (is_string($request->operateur_id))
                $opps=explode(',', $request->operateur_id);
             else
                $opps=$request->operateur_id;
            foreach($opps as $opp)
                $fiches=$fiches->where("operateur","like",'%"'.$opp.'"%');
        }
        $fiches=$fiches->paginate(10);
        foreach($fiches as $fiche)
        {
            $operateur=$fiche->operateur;
            $operateur=str_replace('"', '', $operateur);
            $operateur= json_decode($operateur);
            if($operateur)
             {$operateur = array_map('intval', $operateur);
            $fiche->operateur=Acteur::on('mysql')->whereIn("id",$operateur)->pluck('nom_acteur','id');}
            else
            $fiche->operateur=[];
        }
        if ($request->ajax())
            return view('pages.fichespartial', compact('fiches'))->render();
        $acteurs= Acteur::on('mysql')->orderBy("nom_acteur")->get();
        return view('pages.fiches',['fiches'=>$fiches,'acteurs'=>$acteurs,]);
    }
    public function ficheCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        $name=$request->input("name");
        $domaines = $request->input('choices', []);
        $dom="[";
        foreach($domaines as $domaine)
        {
            $dom=$dom.'"'.$domaine.'"'.",";
        }
        $dom = substr($dom, 0, -1);
        $dom=$dom."]";
        $dbFiche = Fiche::on('mysql')->where('name', $name)->first();
        if($dbFiche)
            return redirect()->back()->with('error','Fiche déjà existante !');
        $fiche=new Fiche();
        $fiche->name=$name;
        $fiche->operateur=$dom;
        $fiche->setConnection('mysql')->save();
        event(new FicheCreated($fiche));
        return redirect()->back()->with('success','Fiche ajoutée !');
    }
    public function ficheDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        $id=$request->input("idFiche");
        $fiche=Fiche::on('mysql')->where("id",$id)->first();
        if(!$fiche)
            return redirect()->back()->with('error','Fiche inexistante !');
        $form=FormSave::on('mysql')->where("fiche_id",$id)->first();
        if($form)
            return redirect()->back()->with('error','Fiche non supprimée : contient une formulaire !');
        $fiche->setConnection('mysql')->delete();
        return redirect()->back()->with('success','Fiche supprimé !');
    }
    public function ficheUpdate(Request $request)
    {   if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modifier !");

    }
        $id=$request->input("id");
        $name=$request->input("nameFiche");
        $domaines = $request->input('acteurs', []);
        $dom="[";
        foreach($domaines as $domaine)
        {
            $dom=$dom.'"'.$domaine.'"'.",";
        }
        $dom = substr($dom, 0, -1);
        $dom=$dom."]";
        $dbFiche = Fiche::on('mysql')->where('name', $name)->where("id","!=",$id)->first();
        if($dbFiche)
            return redirect()->back()->with('error','Fiche déjà existante !');
        $fiche=Fiche::on('mysql')->where("id",$id)->first();
        $fiche->name=$name;
        $fiche->operateur=$dom;
        $fiche->setConnection('mysql')->save();
        return redirect()->back()->with('success','Fiche ajoutée !');
    }
    public function ficheDetails(Request $request,$id)
    {
        $fiche=Fiche::on('mysql')->where("id",$id)->first();
        if(!$fiche)
            return redirect()->back()->with('error','Aucune fiche trouvé !');
        $forms=FormSave::on('mysql')->where("fiche_id",$id);
        $files=FormExcel::on('mysql')->where("fiche_id",$id);
        $intern=FormIntern::on("sqlsrv")->where("fiche_id",$id);
        if($request->has("periodicite"))
            {
                 if($request->periodicite!==null)
                    {$forms=$forms->where("periodicite",$request->periodicite);
                    $files=$files->where("periodicite",$request->periodicite);
                    $intern=$intern->where("periodicite",$request->periodicite);
                    }
            }
        if($request->has("visibility"))
        {   if($request->visibility!==null)
                {$forms=$forms->where("visibility",$request->visibility);
                $files=$files->where("visibility",$request->visibility);
                $intern=$intern->where("visibility",$request->visibility);
                }
        }
        if($request->has("name")&&$request->name!==null)
        {   $forms=$forms->where("name","like","%".$request->name."%");
            $files=$files->where("name","like","%".$request->name."%");
            $intern=$intern->where("name","like","%".$request->name."%");
        }
        $forms=$forms->paginate(10);
        $files=$files->paginate(10);
        $intern=$intern->paginate(10);
        if($request->ajax())
            return view('pages.formulairespartial',['forms'=>$forms,"files"=>$files,"intern"=>$intern,"idFiche"=>$id])->render();
       return view('pages.formulaires',['forms'=>$forms,"files"=>$files,"intern"=>$intern,"idFiche"=>$id]);
    }
    public function formulaireDelete(Request $request)
    {   if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        $id=$request->input("idFormulaire");
        $type=$request->input("type");
        if($type==="intern")
        {
            $form=FormIntern::on("sqlsrv")->find($id);
            if(!$form)
            return redirect()->back()->with('error','Aucune formulaire trouvé !');
            $sub=SubmissionIntern::on('sqlsrv')->where("form_id",$id)->first();
            if($sub)
                return redirect()->back()->with('error','Formulaire soumis et ne peut pas être supprimé !');
            $form->setConnection('sqlsrv')->delete();
            return redirect()->back()->with('success','Formulaire supprimé !');
        }
        $form=FormSave::on('mysql')->find($id);
        if(!$form)
            return redirect()->back()->with('error','Aucune formulaire trouvé !');
        $sub=submission::on('mysql')->where("form_id",$id)->first();
        if($sub)
            return redirect()->back()->with('error','Formulaire soumis et ne peut pas être supprimé !');
        $form->setConnection('mysql')->delete();
        return redirect()->back()->with('success','Formulaire supprimé !');
    }
    public function fichierDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        $id=$request->input("idFichier");
        $form=FormExcel::on('mysql')->where("id",$id)->first();
        if(!$form)
            return redirect()->back()->with('error','Aucun fichier trouvé !');
        $sub=SubmissionExcel::on('mysql')->where("form_id",$id)->first();
        if($sub)
            return redirect()->back()->with('error','Fichier soumis est ne peut pas être supprimé !');
        $form->setConnection('mysql')->delete();
        return redirect()->back()->with('success','Fichier supprimé !');
    }
    public function setBrou(Request $request)
    {
        $request->session()->put('brouillon',"true");
        $previousUrl = url()->previous();
            $parsedUrl = parse_url($previousUrl);
            $queryParams = [];

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }
            $queryParams['page'] = 1;

            // Rebuild the URL with the modified query parameters
            $newUrl = $parsedUrl['path'] . '?' . http_build_query($queryParams);

            return redirect($newUrl);
    }
    public function destroyBrou(Request $request)
    {   $request->session()->forget('brouillon');
        $previousUrl = url()->previous();
            $parsedUrl = parse_url($previousUrl);
            $queryParams = [];

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }
            $queryParams['page'] = 1;

            // Rebuild the URL with the modified query parameters
            $newUrl = $parsedUrl['path'] . '?' . http_build_query($queryParams);

            return redirect($newUrl);
    }
    public function setType(Request $request)
    {
        $request->session()->put('fichier',"true");
        $request->session()->forget("intern");
            $previousUrl = url()->previous();
            $parsedUrl = parse_url($previousUrl);
            $queryParams = [];

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }
            $queryParams['page'] = 1;

            // Rebuild the URL with the modified query parameters
            $newUrl = $parsedUrl['path'] . '?' . http_build_query($queryParams);

            return redirect($newUrl);


    }
    public function setInt(Request $request)
    {   $request->session()->forget('fichier');
        $request->session()->put('intern',"true");

            $previousUrl = url()->previous();
            $parsedUrl = parse_url($previousUrl);
            $queryParams = [];

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }
            $queryParams['page'] = 1;

            // Rebuild the URL with the modified query parameters
            $newUrl = $parsedUrl['path'] . '?' . http_build_query($queryParams);

            return redirect($newUrl);


    }
    public function deleteType(Request $request)
    {
        $request->session()->forget('fichier');
        $request->session()->forget("intern");
        $previousUrl = url()->previous();
        $parsedUrl = parse_url($previousUrl);
            $queryParams = [];

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }
            $queryParams['page'] = 1;

            // Rebuild the URL with the modified query parameters
            $newUrl = $parsedUrl['path'] . '?' . http_build_query($queryParams);

            return redirect($newUrl);

    }
    public function formulaire(Request $request)
    {   if(!$request->input("id"))
            return redirect()->back();
        $fiche=Fiche::on('mysql')->where("id",$request->input("id"))->first();
        return view('pages.createForm',["fiche"=>$fiche]);
    }
    public function formulaireCopie(Request $request)
    {
       if(!$request->input("id"))
            return redirect()->back();
            if($request->input("type")==="intern")
            {
                $form=FormIntern::on('sqlsrv')->where("id",$request->id)->first();
                $fiche=Fiche::on('sqlsrv')->where("id",$request->input("fiche_id"))->first();
            }
            else
        { $form=FormSave::on('mysql')->where("id",$request->id)->first();
            $fiche=Fiche::on('mysql')->where("id",$request->input("fiche_id"))->first();
        }
        return view('pages.copieForm',["fiche"=>$fiche,"form"=>$form]);
    }
    public function formulaireUpdateView(Request $request)
    {
        if(!$request->input("id"))
            return redirect()->back();
        if($request->input("type")==="intern")
        {
            $form=FormIntern::on('sqlsrv')->where("id",$request->id)->first();
            $fiche=Fiche::on('sqlsrv')->where("id",$request->input("fiche_id"))->first();
        }
        else
        {
        $form=FormSave::on('mysql')->where("id",$request->id)->first();
        $fiche=Fiche::on('mysql')->where("id",$request->input("fiche_id"))->first();
        }
        return view('pages.updateForm',["fiche"=>$fiche,"form"=>$form]);
    }
    public function formulaireUpdate(Request $request)
    {if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        if($request->visibility==="PUBLIQUE")
        {$form= FormSave::on('mysql')->where("id",$request->id)->first();
        $form->name=$request->name;
        $form->section=$request->section;
        $form->user_id=1;
        $form->visibility=$request->visibility;
        $form->periodicite=$request->periodicite;
        $form->formJson=$request->formJson;
        $form->setConnection('mysql')->save();}
        else
        {
            $form=FormIntern::on('sqlsrv')->where("id",$request->id)->first();
            $form->name=$request->name;
            $form->user_id=auth()->user()->id;
            $form->visibility=$request->visibility;
            $form->periodicite=$request->periodicite;
            $form->formJson=$request->formJson;
            $form->timestamps=false;
            $form->updated_at=Carbon::now()->format('Ymd H:i:s');
            $form->setConnection('sqlsrv')->save();
            $form->timestamps=true;
        }
        return redirect()->route("fiche.detail",["id"=>$form->fiche_id])->with("success","Formulaire mis à jour !");
    }
    public function formulaireCreate(Request $request)
    {   if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        if($request->visibility==="PUBLIQUE")
        {$form=new FormSave();
        $form->name=$request->name;
        $form->section=$request->section;
        $form->user_id=1;
        $form->fiche_id=$request->id;
        $form->visibility=$request->visibility;
        $form->periodicite=$request->periodicite;
        $form->formJson=$request->formJson;
        $form->setConnection('mysql')->save();}
        else {
            $form=new FormIntern();
            $form->name=$request->name;
            $form->user_id=auth()->user()->id;
            $form->fiche_id=$request->id;
            $form->visibility=$request->visibility;
            $form->periodicite=$request->periodicite;
            $form->formJson=$request->formJson;
            $form->timestamps=false;
            $form->created_at=Carbon::now()->format('Ymd H:i:s');
            $form->setConnection('sqlsrv')->save();
            $form->timestamps=true;
        }
        return redirect()->route("fiche.detail",["id"=>$request->id])->with("success","Formulaire ajouté !");
    }

    public function formules(Request $request)
    {   $formules=Formule::on("mysql");
        if($request->has("acteur")&&$request->acteur!==null)
            $formules=$formules->where("operateur_id",$request->acteur);
        if($request->has("formulaire")&&$request->formulaire!=="")
        {
            $formulaires=FormSave::on("mysql")->where("name","like","%".$request->formulaire."%")->pluck("id");
            $formules=$formules->whereIn("form_id",$formulaires);
        }
        $formules=$formules->paginate(10);
        foreach($formules as $formule)
        {
            $formule->name=FormSave::on("mysql")->where("id",$formule->form_id)->first()->name;
            $formule->acteur=Acteur::on("mysql")->where("id",$formule->operateur_id)->first()->nom_acteur;
        }

        if($request->ajax())
            return view('pages.formulespartial',['formules'=>$formules])->render();
        $acteurs=Acteur::on("mysql")->orderBy('nom_acteur')->get();
        return view('pages.formules',['formules'=>$formules,"acteurs"=>$acteurs,]);
    }
    public function formulesCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        if(!$request->has("acteur"))
            return redirect()->back()->with("error","Acteur est obligatoire");
        if(!$request->has("formulaire"))
            return redirect()->back()->with("error","Formulaire est obligatoire");
        if(!$request->has("pourcentage"))
            return redirect()->back()->with("error","Pourcentage est obligatoire");
        $formules=Formule::on("mysql")->where("operateur_id",$request->acteur)->where("form_id",$request->formulaire)->first();
        if($formules)
            return redirect()->back()->with("error","Formule existe déjà !");
        $formule=new Formule();
        $formule->operateur_id=$request->acteur;
        $formule->form_id=$request->formulaire;
        $formule->timestamps=false;
        $formule->pourcentage=$request->pourcentage;
        $formule->operation=$request->operation;
        $formule->setConnection('mysql')->save();
        return redirect()->back()->with("success","Formule correctement ajoutée !");
    }
    public function formulesUpdate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        if(!$request->has("idFormule"))
            return redirect()->back()->with("error","Acteur est obligatoire");
        $formules=Formule::on("mysql")->where("id",$request->idFormule)->first();
        if(!$formules)
            return redirect()->back()->with("error","Formules inexistante");
        $formules->pourcentage=$request->pourcentage;
        $formules->operation=$request->operation;
        $formules->setConnection('mysql')->save();
        return redirect()->back()->with("success","Formules modifiée !");
    }
    public function formulesDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        if(!$request->has("idActeur"))
            return redirect()->back()->with("error","Erreur de suppression");
        $formules=Formule::on("mysql")->where("id",$request->idActeur)->first();
        if(!$formules)
            return redirect()->back()->with("error","Formules inexistante");
        $formules->setConnection('mysql')->delete();
        return redirect()->back()->with("success","Formule correctement supprimée!");
    }
    public function getEveryForm($id)
    {
        $fiches=Fiche::on('mysql')->where("operateur","like",'%"'.$id.'"%')->pluck("id");
        $forms=FormSave::on('mysql')->whereIn("fiche_id",$fiches)->orderBy("name")->get();
        $options = '<option value="">Select a Form</option>';
        foreach ($forms as $form) {
            $options .= "<option value='{$form->id}'>{$form->name}</option>";
        }
        return $options;
    }
    public function getEveryFormSql($id)
    {
        $fiches=Fiche::on('sqlsrv')->where("operateur","like",'%"'.$id.'"%')->pluck("id");
        $forms=FormSave::on('sqlsrv')->whereIn("fiche_id",$fiches)->orderBy("name")->get();
        $options = '<option value="">Select a Form</option>';
        foreach ($forms as $form) {
            $options .= "<option value='{$form->id}'>{$form->name}</option>";
        }
        return $options;
    }
    public function getPeriodicite(Request $request)
    {
        $form=FormSave::on("sqlsrv")->find($request->form_id);
        if(!$form)
            return "<option value=''>Aucun formulaire trouvé</option>";
        $options = '<option value="">Selectionnez une Période</option>';
        if($form->periodicite==="annuelle")
            {$options.="<option value='A'>A</option>";
            return $options;}
        if($form->periodicite==="mensuelle")
            {$char="M";
            $number=12;}
        elseif($form->periodicite==="trimestrielle")
           { $char="TR";
            $number=4;}
        else
            {$char="S";
            $number=2;}
        for($i=1;$i<=$number;$i++)
            {
                $options.="<option value='{$char}{$i}'>{$char}{$i}</option>";
            }
        return $options;
    }
    public function getPeriodicite2(Request $request)
    {
        $form=FormSave::on("mysql")->find($request->form_id);
        if(!$form)
            return "<option value=''>Aucun formulaire trouvé</option>";
        $options = '<option value="">Selectionnez une Période</option>';
        if($form->periodicite==="annuelle")
            {$options.="<option value='A'>A</option>";
            return $options;}
        if($form->periodicite==="mensuelle")
            {$char="M";
            $number=12;}
        elseif($form->periodicite==="trimestrielle")
           { $char="TR";
            $number=4;}
        else
            {$char="S";
            $number=2;}
        for($i=1;$i<=$number;$i++)
            {
                $options.="<option value='{$char}{$i}'>{$char}{$i}</option>";
            }
        return $options;
    }
    public function processItem(&$item,$amount) {
        if (is_array($item) || is_object($item)) {
        foreach ($item as $key => &$value) {
            if (is_array($value)) {
                $this->processItem($value,$amount);
            } elseif (is_numeric($value)) {
                $value = $value * $amount;
            }
        }}
    }
    public function transformData($jsonData,$amount)
    {
        $dataArray = json_decode($jsonData, true);
        foreach ($dataArray['data'] as &$serviceData) {
            $this->processItem($serviceData,$amount);
        }
        return json_encode($dataArray, JSON_PRETTY_PRINT);
    }
    public function formulesSaisie(Request $request)
    {
        $period=$request->periodicite;
        $year=$request->annee;
        $sub=submission::on("mysql")->where("operateur_id",$request->acteur)->where("form_id",$request->formulaire)->where("periodicity",$period)->where("year",$year)->where("type","final")->first();
        $formule=Formule::on("mysql")->where("operateur_id",$request->acteur)->where("form_id",$request->formulaire)->first();
        if(!$formule)
            return response()->json(["error"=>"Aucune formule associée à ce formulaire. Accéder à la page Formule pour configurer la formule pour ce formulaire/Opérateur!"]);
        $amount=1;
        if($formule->operation==="-")
            $amount-=($formule->pourcentage/100);
        else
            $amount+=($formule->pourcentage/100);
        $sub=submission::on("mysql")
            ->where(function ($query) use($period,$year) {
                $query->where("periodicity","!=",$period)
                ->orWhere("year","!=",$year);})
            ->where("operateur_id",$request->acteur)
            ->where("type","final")
            ->where("form_id",$request->formulaire)->latest("created_at")->first();
        if(!$sub)
            return response()->json(["error"=>"Aucune soumission pour ce formulaire réalisée par cet acteur !"]);
        $data=$this->transformData($sub->formJson,$amount);
        return response()->json(["data"=>$data]);
    }

    public function system()
    {
        $system=SystemTime::on("mysql")->find(1);
        $year=submission::on("sqlsrv")->min("year") || 2014;
        $system2=SystemTime::on("mysql")->find(2);
        return view("pages.systemtime",["system2"=>$system2,"system"=>$system,"year"=>$year]);
    }
    public function periodicite()
    {
        $validation=validation_time::on("mysql")->get();
        return view("pages.parametre",["validation"=>$validation]);
    }
    public function changeYear(Request $request)
    {if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        if(!$request->has("year"))
            return redirect()->back()->with("error","Sélectionnez une année");
        if(!$request->has("mois"))
            return redirect()->back()->with("error","Sélectionnez un mois");
        if(!$request->id)
            return redirect()->back()->with("error","Erreur innatendu !");
        $system=SystemTime::on("mysql")->find($request->id);
        $system->year=$request->year;
        $system->mois=$request->mois;
        $system->setConnection("mysql")->save();
        return redirect()->back()->with("success","Date du système mise à jour");
    }
    public function changeValid(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        if(!$request->has("periodicite"))
            return redirect()->back()->with("error","Sélectionnez une périodicité");
        $validation=validation_time::on("mysql")->where("periodicite",$request->periodicite)->first();
        $validation->periodicite=$request->periodicite;
        $validation->start_day=$request->start;
        $validation->final_day=$request->final;
        $validation->increment_start=$request->incs;
        $validation->increment_final=$request->incf;
        $validation->setConnection("mysql")->save();
        return redirect()->back()->with("success","Mise à jour de la périodicité effectuée avec succès");
    }
    public function sendMail(Request $request)
    {
        $userEmail = $request->input('email');
        $subject = $request->input('sujet');
        $message = $request->input('contenu');
        $attachment = $request->file('file');
        // Send email using the Mail facade

        try
        {Mail::to($userEmail)->send(new SendUser($subject, $message, $attachment));
        }
        catch(TransportExceptionInterface $e)
        {           return redirect()->back()->with("error","Email inexistant");


        }

        return redirect()->back()->with('success', 'Email envoyé avec succès !');

    }
    public function dataCloud(Request $request)
    {
        $files=submission::on("mysql")->with("form")->where("type","final")->orderBy("created_at");
        $fichier=SubmissionExcel::on("mysql")->with("form")->where("type","final")->orderBy("created_at");
        if($request->name)
        {   $formName = $request->input('name');
            $files=$files->whereHas('form', function ($query) use ($formName) {
                $query->where('name',"like", "%".$formName."%");
            });
            $fichier=$fichier->whereHas("form",function ($query) use ($formName) {
                $query->where('name',"like", "%".$formName."%");
            });
        }
        if($request->fiche){
            $id=$request->fiche;
            $files=$files->whereHas('form', function ($query) use ($id) {
                $query->where("fiche_id",$id);
            });
            $fichier=$fichier->whereHas('form', function ($query) use ($id) {
                $query->where("fiche_id",$id);
            });

        }
        if($request->acteur)
        {
            $files=$files->where("operateur_id",$request->acteur);
            $fichier=$fichier->where("acteur_id",$request->acteur);
        }
        if($request->annee)
        {  $files=$files->where("year",$request->annee);
            $fichier=$fichier->where("year",$request->annee);

        }
        if($request->periodicite)
        {  $files=$files->where("periodicity",$request->periodicite);
            $fichier=$fichier->where("periodicity",$request->periodicite);
        }
        $files=$files->paginate(10);
        $fichier=$fichier->paginate(10);
        foreach($files as $file)
        {
            $opp=Acteur::on("mysql")->where("id",$file->operateur_id)->first();
            if(!$opp)
                $file->name="Admin";
            else
                $file->name=$opp->nom_acteur;
            $comm=Commentaire::on("mysql")->where("submission_id",$file->id)->get();
            $file->comm=$comm;
        }
        foreach($fichier as $file)
        {
            $opp=Acteur::on("sqlsrv")->where("id",$file->acteur_id)->first();
            if(!$opp)
                $file->name="Admin";
            else
                $file->name=$opp->nom_acteur;
            $comm=CommentaireExcel::on("mysql")->where("submission_id",$file->id)->get();
            $file->comm=$comm;
        }
        if($request->ajax())
            return view("pages.dataCloudpartial",["files"=>$files,"fichiers"=>$fichier,])->render();
        $acteur=Acteur::on("mysql")->orderBy("nom_acteur")->get();
        $fiches=Fiche::on("mysql")->orderBy("name")->get();
        return view("pages.dataCloud",["files"=>$files,"acteurs"=>$acteur,"fichiers"=>$fichier,"fiches"=>$fiches]);

    }
    public function reouvrir(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        $user=User::on("mysql")->where("operateur_id",$request->acteur)->first();
        if(!$user)
            return redirect()->back()->with(["error"=>"Cet opérateur n'a pas un utilisateur qui le présente"]);
        $form_id=$request->formulaire;
        $periodicite=$request->periodicite;
        $annee=$request->annee;
        $type=$request->type;
        if($type==="fichier")
            $sub=SubmissionExcel::on("mysql")->where("user_id",$user->id)->where("form_id",$form_id)->where("year",$annee)->where("periodicity",$periodicite)->first();
        else
         $sub=submission::on("mysql")->where("user_id",$user->id)->where("form_id",$form_id)->where("year",$annee)->where("periodicity",$periodicite)->first();
        if(!$sub)
        {
            $sub= $type==="fichier"?new SubmissionExcel():new submission();
            if($type==="fichier")
            {
                $sub->acteur_id=$request->acteur;
                $sub->excel="";
                $sub->mime="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
            }
            else
            {
                $sub->operateur_id=$request->acteur;
                $sub->formHistoric_id=0;
                $sub->commentaire="";
                $sub->formJson="{}";
                $sub->ESTIMATED="Y";
            }
            $sub->user_id=$user->id;
            $sub->form_id=$form_id;
            $sub->periodicity=$periodicite;
            $sub->year=$annee;
            $sub->historique="L";
            $sub->type="refaire";

            $sub->setConnection("mysql")->save();
            return response()->json(["success"=>strtoupper($request->type)." ré-ouvert avec succès !"]);

        }
        else if($sub->type==="draft")
        {   $sub->ESTIMATED="Y";
            $sub->type="refaire";
            $sub->setConnection("mysql")->save();
            return response()->json(["success"=>"Formulaire ré-ouvert avec succès !"]);

        }
        else if($sub->type==="final")
        {
            return response()->json(["error"=>"Le ".$request->type." est déja envoyé par cet opérateur pour cette périodicité !"]);
        }
        else
        {
            return response()->json(["error"=>"Le ".$request->type." est déja ouvert pour cet opérateur !"]);
        }
    }
    public function suivi(Request $request)
    {   $suivi=Acteur::on("mysql")->orderBy("nom_acteur");
        if($request->acteur)
            {if (is_string($request->acteur))
                $opps=explode(',', $request->acteur);
            else
                $opps=$request->acteur;
            $acteur=array_map('intval', $opps);
           $suivi=$suivi->whereIn("id",$acteur);
        }
        $suivi=$suivi->paginate(10);
        foreach($suivi as $suiv)
        {   $fichet=Fiche::on("mysql");
            if($request->fiche )
                {
                    $fichet=$fichet->where("id",$request->fiche);
                }
            $fichet=$fichet->where("operateur","like",'%"'.$suiv->id.'"%')->get()->pluck("id");
            $form=FormSave::on("mysql")->whereIn("fiche_id",$fichet);
            $fichier=FormExcel::on("mysql")->whereIn("fiche_id",$fichet);
            if($request->periodicite)
            {   $period="";
                $a=$request->periodicite[0];
                if($a==="M")
                    $period="mensuelle";
                else if($a==="T")
                    $period="trimestrielle";
                else if($a==="S")
                    $period="semestrielle";
                else
                    $period="annuelle";
                $form=$form->where("periodicite",$period);
                $fichier=$fichier->where("periodicite",$period);
            }
            if($request->name)
            {
                $form=$form->where("name","like","%".$request->name."%");
                $fichier=$fichier->where("name","like","%".$request->name."%");

            }
            $form=$form->get();
            $fichier=$fichier->get();
            $suiv->faire=0;
            $suiv->cours=0;
            $suiv->redo=0;
            $suiv->final=0;
            foreach($form as $f)
            {
                if($request->periodicite)
                    $periodicite=$request->periodicite;
                else
                    $periodicite=HomeController::time($f->periodicite,"mysql");
                if($request->annee)
                    $year=$request->annee;
                else
                    $year=HomeController::year($periodicite);
                $sub=submission::on("mysql")->where("form_id",$f->id)->where("operateur_id",$suiv->id)->where("periodicity",$periodicite)->where("year",$year)->first();
                if($sub)
                    {
                        if($sub->type==="final")
                            $suiv->final++;
                        else if($sub->type==="draft")
                            $suiv->cours++;
                    }
                else
                    $suiv->faire++;
            }
            foreach($fichier as $f)
            {
                if($request->periodicite)
                    $periodicite=$request->periodicite;
                else
                    $periodicite=HomeController::time($f->periodicite,"mysql");
                if($request->year)
                    $year=$request->year;
                else
                    $year=HomeController::year($periodicite);
                $sub=submissionExcel::on("mysql")->where("form_id",$f->id)->where("acteur_id",$suiv->id)->where("periodicity",$periodicite)->where("year",$year)->first();
                if($sub)
                    {
                        if($sub->type==="final")
                            $suiv->final++;
                        else if($sub->type==="draft")
                            $suiv->cours++;
                    }
                else
                    $suiv->faire++;
            }
            $sur=submission::on("mysql")->whereIn("form_id",$form->pluck("id"))->where("operateur_id",$suiv->id)->where("type","refaire")->get()->count();
            $sur1=submissionExcel::on("mysql")->whereIn("form_id",$form->pluck("id"))->where("acteur_id",$suiv->id)->where("type","refaire")->get()->count();
            $suiv->redo=$sur+$sur1;
        }
        if($request->ajax())
            return view("pages.suiviespartial",["suivi"=>$suivi,])->render();
        $acteur=Acteur::on("mysql")->orderBy("nom_acteur")->get();
        $fiches=Fiche::on("mysql")->orderBy("name")->get();
        return view("pages.suivies",["suivi"=>$suivi,"acteurs"=>$acteur,"fiches"=>$fiches]);
    }
    public function group(Request $request)
    {

        $groupes=Groupe::on("mysql");
        if($request->name)
            $groupes=$groupes->where("nom","like",'%'.$request->name."%");
        $groupes=$groupes->orderBy("priorite")->paginate(10);
        if ($request->ajax()) {
            return view('pages.groupespartial', compact('groupes'))->render();
        }
        $largestPriorite = Groupe::on("mysql")->get()->max('priorite');
            if(!$largestPriorite)
                $largestPriorite=0;
        return view('pages.groupes',['groupes'=>$groupes,"priorite"=>$largestPriorite]);

    }
    public function groupAdd(Request $request)
    {   if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        if(!$request->nom)
        {
            return redirect()->back()->with("error","Nom du groupe obligatoire !");
        }
        $gr=Groupe::on("mysql")->where("nom",$request->nom)->first();
        if($gr)
        {
            return redirect()->back()->with("error","Nom du groupe déja utilisé !");
        }
        $largestPriorite = Groupe::on("mysql")->get()->max('priorite');
        if($request->priorite!==$largestPriorite)
            {
                if($request->type==="permutation")
                {$fichier=Groupe::on("mysql")->where("priorite",$request->priorite)->first();
                if($fichier)
                {
                    $fichier->priorite=$largestPriorite+1;
                    $fichier->setConnection("mysql")->save();
                }
                }
                else
                {
                    Groupe::whereBetween('priorite', [$request->priorite, $largestPriorite])
                ->increment('priorite', 1);
                }
            }
        $groupe=new Groupe();
        $groupe->nom=$request->nom;
        $groupe->dep=$request->dep;
        $groupe->priorite=$request->priorite;
        $groupe->setConnection("mysql")->save();
        return redirect()->back()->with("success","Groupe enregistré avec succès !");
    }
    public function groupUpdate(Request $request)
    {   if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        if(!$request->nom || !$request->id)
        {
            return redirect()->back()->with("error","Nom du groupe obligatoire !");
        }
        $gr=Groupe::on("mysql")->where("id",$request->id)->first();
        if(!$gr)
        {
            return redirect()->back()->with("error","Groupe inexistant !");
        }
        $gr1=Groupe::on("mysql")->where("id","!=",$request->id)->where("nom",$request->nom)->first();
        if($gr1)
        {
            return redirect()->back()->with("error","Nom du groupe déja utilisé !");
        }
        $largestPriorite =$gr->priorite;
        if(intval($request->priorite)!==$largestPriorite)
            {
                if($request->type==="permutation")
                {$fichier=Groupe::on("mysql")->where("priorite",$request->priorite)->first();
                if($fichier)
                {
                    $fichier->priorite=$largestPriorite;
                    $fichier->setConnection("mysql")->save();
                }
                }
                else
                {
                    if($largestPriorite>$request->priorite)
                    {Groupe::whereBetween('priorite', [$request->priorite, $largestPriorite])
                ->increment('priorite', 1);}
                else
                {

                Groupe::whereBetween('priorite', [ $largestPriorite,$request->priorite])
                ->decrement('priorite', 1);
                }
                }
            }
        $gr->dep=$request->dep;
        $gr->nom=$request->nom;
        $gr->priorite=$request->priorite;
        $gr->setConnection("mysql")->save();
        return redirect()->back()->with("success","Groupe modifié avec succès !");
    }
    public function groupeDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        if(!$request->id)
            return redirect()->back()->with("error","Groupe introuvable !");
        $gr=Groupe::on("mysql")->where("id",$request->id)->first();
        if(!$gr)
        {
            return redirect()->back()->with("error","Groupe inexistant !");
        }
        $st=GroupeForm::on("mysql")->where("groupe_id",$gr->id)->first();
        if($st)
        {
            return redirect()->back()->with("error","Groupe contient déja des formulaires !");
        }
        $largestPriorite = Groupe::on("mysql")->max('priorite');
        if($largestPriorite!==$gr->priorite)
        {
            Groupe::whereBetween("priorite", [$gr->priorite, $largestPriorite])
                ->decrement("priorite",1);
        }
        $gr->setConnection("mysql")->delete();
        return redirect()->back()->with("success","Groupe supprimé avec succès !");
    }
    public function groupDetails(Request $request)
    {
        $groupes=GroupeForm::on("mysql")->where("groupe_id",$request->id);
        $formsWithPriority = GroupeForm::on("mysql")->where("type","formulaire")->get()->pluck("form_save_id");
        $fichierWithPriority =  GroupeForm::on("mysql")->where("type","fichier")->get()->pluck("form_save_id");
        $form=GroupeForm::on("mysql")->where("groupe_id",$request->id)->orderBy("priorite")->get();
        foreach($form as $f)
        {
            if($f->type==="formulaire")
                $fet=FormSave::on("mysql")->find($f->form_save_id);
            else
                $fet=FormExcel::on("mysql")->find($f->form_save_id);
            if($fet)
            $f->name=$fet->name;
        }
        if ($request->name) {
            $form = $form->filter(function($item) use ($request) {
                return stripos($item->name, $request->name) !== false;
            });
        }
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $form->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $form = new LengthAwarePaginator($currentItems, $form->count(), $perPage);
        $form->setPath(url()->current());
        $form->appends(['name' => $request->name]);


        if ($request->ajax()) {
            return view('pages.groupesDetailpartial', compact('form'))->render();
        }

        $forms=FormSave::on("mysql")->whereNotIn("id",$formsWithPriority)->orderBy("name")->get();

        $fichier=FormExcel::on("mysql")->whereNotIn("id",$fichierWithPriority)->orderBy("name")->get();
        $largestPriorite = GroupeForm::on("mysql")->where("groupe_id",$request->id)->max('priorite');
            if(!$largestPriorite)
                $largestPriorite=0;
        return view('pages.groupesDetail',['form'=>$form,"fichier"=>$fichier,'forms'=>$forms,'priorite'=>$largestPriorite,'groupe_id'=>$request->id]);

    }
    public function groupDetailsCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        if(!$request->form || !$request->priorite || !$request->groupe || !$request->type2)
        {
            return redirect()->back()->with("error","Erreur !");
        }
        $form=GroupeForm::on("mysql")->where("form_save_id",$request->form)->where("type",$request->type2)->first();
        if($form)
            return redirect()->back()->with("error","Ce formulaire appartient déja à un groupe !");
        $largestPriorite = GroupeForm::on("mysql")->where("groupe_id",$request->groupe)->max('priorite');
        if($request->priorite!==$largestPriorite)
            {
                if($request->type==="permutation")
                {$fichier=GroupeForm::on("mysql")->where("groupe_id",$request->groupe)->where("priorite",$request->priorite)->first();
                if($fichier)
                {
                    $fichier->priorite=$largestPriorite+1;
                    $fichier->setConnection("mysql")->save();
                }}
                else
                {
                    GroupeForm::where('groupe_id', $request->groupe)
                ->whereBetween('priorite', [$request->priorite, $largestPriorite])
                ->increment('priorite', 1);
                }
            }
        $groupe=Groupe::on("mysql")->find($request->groupe);
        $form=FormSave::on("mysql")->find($request->form);
        $gr=new GroupeForm();
        $gr->form_save_id=$request->form;
        $gr->dep=$request->dep;
        $gr->type=$request->type2;
        $gr->groupe_id=$request->groupe;
        $gr->priorite=$request->priorite;
        $gr->setConnection("mysql")->save();
        return redirect()->back()->with("success","Formulaire ajouté à ce groupe !");
    }
    public function groupDetailsUpdate(Request $request)
    {if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        if(!$request->form || !$request->priorite || !$request->groupe)
        {
            return redirect()->back()->with("error","Erreur !");
        }
        $form=GroupeForm::on("mysql")->find($request->form);
            if(!$form)
            return redirect()->back()->with("error","Ce formulaire n'appartient pas à ce groupe !");
        $largestPriorite =$form->priorite;
        if(intval($request->priorite)!==$largestPriorite)
            {
                if($request->type==="permutation")
                {$fichier=GroupeForm::on("mysql")->where("groupe_id",$request->groupe)->where("priorite",$request->priorite)->first();
                if($fichier)
                {
                    $fichier->priorite=$largestPriorite;
                    $fichier->setConnection("mysql")->save();
                }
                }
                else
                {
                    if($largestPriorite>$request->priorite)
                    {GroupeForm::where('groupe_id', $request->groupe)
                ->whereBetween('priorite', [$request->priorite, $largestPriorite])
                ->increment('priorite', 1);}
                else
                {

                GroupeForm::where('groupe_id', $request->groupe)
                ->whereBetween('priorite', [ $largestPriorite,$request->priorite])
                ->decrement('priorite', 1);
                }
                }
            }
        $form->priorite=$request->priorite;
        $form->dep=$request->dep;
        $form->setConnection("mysql")->save();
        return redirect()->back()->with("success","Priorité de formulaire/fichier modifié avec succès !");
    }
    public function groupDetailsDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        if(!$request->id||!$request->form)
            return redirect()->back()->with("error","Erreur !");
        $form=GroupeForm::on("mysql")->find($request->form);

        if(!$form)
            return redirect()->back()->with("error","Ce formulaire n'appartient pas à ce groupe !");
        $largestPriorite = GroupeForm::on("mysql")->where("groupe_id",$request->id)->max('priorite');
        if($largestPriorite!==$form->priorite)
        {
            GroupeForm::where('groupe_id', $request->id)
                ->whereBetween('priorite', [$form->priorite, $largestPriorite])
                ->decrement("priorite",1);
        }
        $form->setConnection("mysql")->delete();
        return redirect()->back()->with("success","Formulaire/Fichier supprmié de ce groupe !");

    }
    public function soumission(Request $request)
    {
        $acteur=$request->acteur;
        $id=$request->id;
        $forms=FormSave::on("sqlsrv")->where("fiche_id",$id);
        $excel=FormExcel::on("sqlsrv")->where("fiche_id",$id);
        if($request->name)
            {
                $forms=$forms->where("name","like","%".$request->name."%");
                $excel=$excel->where("name","like","%".$request->name."%");
            }
        if($request->periodicite)
        {
            if($request->periodicite[0]==="M")
            {
                $pe="mensuelle";
            }
            else if($request->periodicite[0]==="T")
            {
                $pe="trimestrielle";
            }
            else if($request->periodicite[0]==="S")
            {
                $pe="semestrielle";
            }
            else
            {
                $pe="annuelle";
            }
            $forms=$forms->where("periodicite",$pe);
            $excel=$excel->where("periodicite",$pe);
        }
        $forms=$forms->get();
        $excel=$excel->get();
        $count=new \stdClass();
        $count->faire=0;
        $count->cours=0;
        $count->env=0;
        foreach($forms as $form)
        {   if($request->periodicite)
                $periodicite=$request->periodicite;
            else
                $periodicite=HomeController::time($form->periodicite,"sqlsrv");
            if($request->year)
                $year=$request->year;
            else
                $year=HomeController::year($periodicite);
            $form->year=$year;
            $form->date_to=$periodicite;
            $a="type_soumission";
            $form->source="publique";
            $sub=submission::on("sqlsrv")->where("form_id",$form->id)->where("operateur_id",$acteur)->where("periodicity",$periodicite)->where("year",$year)->first();
            if($sub)
                    {$form->dataJson=$sub->formJson;
                    $form->type=$sub->$a;
                    $form->created_at=$sub->created_at;
                    $form->updated_at=$sub->updated_at;
                    if($form->type==="draft")
                        $count->cours+=1;
                    else if($form->type==='final')
                        {$count->env+=1;
                        $form->sub_id=$sub->id;
                        }
                    }
            else
                    {
                    $form->type="faire";
                    $count->faire+=1;}

        }
        foreach($excel as $form)
        {   unset($form->excel);
            if($request->periodicite)
                $periodicite=$request->periodicite;
            else
                $periodicite=HomeController::time($form->periodicite,"sqlsrv");
            if($request->year)
                $year=$request->year;
            else
                $year=HomeController::year($periodicite);
            $form->year=$year;
            $form->date_to=$periodicite;
            $a="type";
            $form->source="publique";
            $sub=SubmissionExcel::on("sqlsrv")->where("form_id",$form->id)->where("acteur_id",$acteur)->where("periodicity",$periodicite)->where("year",$year)->first();
            if($sub)
                    {
                    $form->type=$sub->$a;
                    $form->created_at=$sub->created_at;
                    $form->updated_at=$sub->updated_at;
                    if($form->type==="draft")
                        $count->cours+=1;
                    else if($form->type==='final')
                        {$count->env+=1;
                        $form->sub_id=$sub->id;
                        }
                    }
            else
                    {
                    $form->type="faire";
                    $count->faire+=1;}

        }
        $acteurName=Acteur::on("sqlsrv")->find($request->acteur)->nom_acteur;
        if($request->ajax())
            return view("pages.soumissionDetailpartial",["forms"=>$forms,"count"=>$count,"acteur"=>$acteur,"excel"=>$excel])->render( );
        return view("pages.soumissionDetail",["forms"=>$forms,"count"=>$count,"acteur"=>$acteur,"acteurName"=>$acteurName,"excel"=>$excel]);
    }
    public function soumissionIntern(Request $request)
    {
        $acteur=$request->acteur;
        $id=$request->id;
        $forms=FormIntern::on("sqlsrv");
        if($request->name)
            $forms=$forms->where("name","like","%".$request->name."%");
        if($request->periodicite)
        {
            if($request->periodicite[0]==="M")
            {
                $pe="mensuelle";
            }
            else if($request->periodicite[0]==="T")
            {
                $pe="trimestrielle";
            }
            else if($request->periodicite[0]==="S")
            {
                $pe="semestrielle";
            }
            else
            {
                $pe="annuelle";
            }
            $forms=$forms->where("periodicite",$pe);
        }
        $forms=$forms->get();
        $count=new \stdClass();
        $count->faire=0;
        $count->cours=0;
        $count->env=0;
        foreach($forms as $form)
        {   if($request->periodicite)
                $periodicite=$request->periodicite;
            else
                $periodicite=HomeController::time($form->periodicite,"mysql");
            if($request->year)
                $year=$request->year;
            else
                $year=HomeController::year($periodicite);
            $form->year=$year;
            $form->date_to=$periodicite;
            $a="type_soumission";
            $form->source="interne";
            $sub=SubmissionIntern::on("sqlsrv")->where("form_id",$form->id)->where("operateur_id",$acteur)->where("periodicity",$periodicite)->where("year",$year)->first();
            if($sub)
                    {$form->dataJson=$sub->formJson;
                    $form->type=$sub->$a;
                    $form->created_at=$sub->created_at;
                    $form->updated_at=$sub->updated_at;
                    if($form->type==="draft")
                        $count->cours+=1;
                    else if($form->type==='final')
                        {$count->env+=1;
                        $form->sub_id=$sub->id;
                        }
                    }
            else
                    {
                    $form->type="faire";
                    $count->faire+=1;
                    }
        }
        if($request->ajax())
            return view("pages.soumissionDetailpartial",["forms"=>$forms,"count"=>$count,"acteur"=>$acteur,"excel"=>[]])->render( );
        return view("pages.soumissionDetail",["forms"=>$forms,"count"=>$count,"acteur"=>$acteur,"excel"=>[]]);
    }
}
