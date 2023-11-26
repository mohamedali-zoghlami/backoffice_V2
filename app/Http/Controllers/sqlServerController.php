<?php

namespace App\Http\Controllers;
use App\Models\FormSave;
use App\Models\FormExcel;
use App\Models\FormIntern;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Submission;
use App\Models\SubmissionExcel;
use App\Models\Image;
use App\Models\Parametre;
use App\Models\Commentaire;
use App\Models\CommentaireExcel;
use App\Models\SubmissionIntern;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Events\RenvoiFiche;
use App\Listeners\SendRenvoiFicheNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class sqlServerController extends Controller
{
    public function changePicture(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_images'), $imageName);
            $user=User::on("sqlsrv")->findOrFail(auth()->user()->id);
            $user->image=$imageName;
            $user->timestamps=false;
            $user->updated_at=Carbon::now()->format('Ymd H:i:s');
            $user->save();
            $user->timestamps=true;
            Auth::setUser($user);
        }

        return redirect()->back()->with('success', 'Profile image uploaded successfully!');
    }
    public function updateUser(Request $request)
    {
        $name=$request->name;
        $password=$request->password;
        $oldpassword=$request->oldpassword;
        $user=User::on("sqlsrv")->findOrFail(auth()->user()->id);
        if($name)
            {
                $user->name=$name;
                $user->timestamps=false;
                $user->updated_at=Carbon::now()->format('Ymd H:i:s');
                $user->save();
                $user->timestamps=true;
                Auth::setUser($user);
            return redirect()->back()->with("success","Nom mis à jour !");
        }
        else
        {
            if(Hash::check($oldpassword, $user->password))
                {
                    $user->password=Hash::make($password);
                    $user->timestamps=false;
                    $user->updated_at=Carbon::now()->format('Ymd H:i:s');
                    $user->save();
                    $user->timestamps=true;
                    return redirect()->back()->with("success","Mot de passe mis à jour !");
                }
            else
                return redirect()->back()->with("error","L'ancien mot de passe entré est incorrect !");
        }
        return redirect()->back()->with("error","Erreur !");
    }
    public function checkPassword(Request $request)
    {   $user=User::on("sqlsrv")->findOrFail(auth()->user()->id);
        if($request->password)
            if(!Hash::check($request->password, $user->password))
            {
                return response()->json(["error"=>"L'ancien mot de passe entré est incorrect !"]);
            }

        }
    public function soumission(Request $request)
    {
        $fiches=[];
        if($request->acteur)
            $fiches=Fiche::on("sqlsrv")->where("operateur","like",'%"'.$request->acteur.'"%')->get();
        $count=new \stdClass();
        $count->faire=0;
        $count->cours=0;
        $count->env=0;
        foreach($fiches as $fiche)
            {
                $fichet=FormSave::on("sqlsrv")->where("fiche_id",$fiche->id)->get();
                $fiche->forms=$fichet->count();
                $fichette=FormExcel::on("sqlsrv")->where("fiche_id",$fiche->id)->get();
                $fiche->fichier=$fichette->count();
                $fiche->draft=0;
                $fiche->sub=0;
                $fiche->renv=0;
                foreach($fichet as $form)
                {   $periodicity=HomeController::time($form->periodicite,"sqlsrv");
                    $year=HomeController::year($periodicity);
                    $fast=submission::on("sqlsrv")->where("form_id",$form->id)->where("operateur_id",$request->acteur)->where("periodicity",$periodicity)->where("year",$year)->first();
                    if($fast)
                        {
                            if($fast->type_soumission==="final")
                                $fiche->sub+=1;
                            else if($fast->type_soumission==="draft")
                                $fiche->draft+=1;
                            else
                                $fiche->renv+=1;
                        }

                }
                foreach($fichette as $form)
                {   $periodicity=HomeController::time($form->periodicite,"sqlsrv");
                    $year=HomeController::year($periodicity);
                    $fast=SubmissionExcel::on("sqlsrv")->where("form_id",$form->id)->where("acteur_id",$request->acteur)->where("periodicity",$periodicity)->where("year",$year)->first();
                    if($fast)
                        {
                            if($fast->type==="final")
                                $fiche->sub+=1;
                            else if($fast->type==="draft")
                                $fiche->draft+=1;
                            else
                                $fiche->renv+=1;
                        }

                }
                if($fiche->sub===(($fiche->forms+$fiche->fichier)-$fiche->renv)&&$fiche->sub!==0)
                    {$count->env+=1;
                        $fiche->type="env";
                    }
                else if($fiche->sub>0 || $fiche->draft>0)
                    {$count->cours+=1;
                    $fiche->type="cours";
                    }
                else if($fiche->forms>0 || $fiche->fichier>0)
                    $count->faire+=1;
            }
            if($request->ajax())
                return view("pages.soumissionpartial",["fiches"=>$fiches,"count"=>$count,"act"=>$request->acteur])->render();
            $acteur=Acteur::on("sqlsrv")->orderBy("nom_acteur")->get();
            return view("pages.soumission",["acteurs"=>$acteur,"fiches"=>$fiches,"count"=>$count,"act"=>$request->acteur]);
        }
    public function soumissionCU(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        $form=submissionIntern::on("sqlsrv")->where("form_id",$request->form_id)->where("operateur_id",$request->acteur)->where("periodicity",$request->periodicite)->where("year",$request->year)->where("type_soumission","draft")->first();

        if($form)
            {
                $form->formJSON=$request->dataJson;
                $form->type_soumission=$request->type;
                $form->user_id=auth()->user()->id;
                $form->timestamps=false;
                $form->updated_at=Carbon::now()->format('Ymd H:i:s');
                $form->setConnection("sqlsrv")->save();
                $form->timestamps=true;
                return response()->json(['redirect_url' => url()->previous()]);
            }
        $form= new submissionIntern();
        $form->user_id=auth()->user()->id;
        $form->periodicity=$request->periodicite;
        $form->year=$request->year;
        $form->form_id=$request->form_id;
        $form->historique="L";
        $form->operateur_id=$request->acteur;
        $form->formJSON=$request->dataJson;
        $form->type_soumission=$request->type;
        $form->user_id=auth()->user()->id;
        $form->timestamps=false;
        $form->created_at=Carbon::now()->format('Ymd H:i:s');
        $form->setConnection("sqlsrv")->save();
        $form->timestamps=true;
        return response()->json(['redirect_url' => url()->previous()]);
    }
    public function submissionData(Request $request)
    {   $intern=submissionIntern::on("sqlsrv")->with("form")->where("type_soumission","final")->orderBy("created_at");
        $files=submission::on("sqlsrv")->with("form")->where("type_soumission","final")->orderBy("created_at");
        $fichier=SubmissionExcel::on("sqlsrv")->with("form")->where("type","final")->orderBy("created_at");
        if($request->name)
        {   $formName = $request->input('name');
            $files=$files->whereHas('form', function ($query) use ($formName) {
                $query->where('name',"like", "%".$formName."%");
            });
            $fichier=$fichier->whereHas("form",function ($query) use ($formName) {
                $query->where('name',"like", "%".$formName."%");
            });
            $intern=$intern->whereHas("form",function ($query) use ($formName) {
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
            $intern=$intern->whereHas('form', function ($query) use ($id) {
                $query->where("fiche_id",$id);
            });
        }
        if($request->acteur)
        {
            $files=$files->where("operateur_id",$request->acteur);
            $fichier=$fichier->where("acteur_id",$request->acteur);
            $intern=$intern->where("operateur_id",$request->acteur);
        }
        if($request->annee)
        {  $files=$files->where("year",$request->annee);
            $fichier=$fichier->where("year",$request->annee);
            $intern=$intern->where("year",$request->annee);
        }
        if($request->periodicite)
        {  $files=$files->where("periodicity",$request->periodicite);
            $fichier=$fichier->where("periodicity",$request->periodicite);
            $intern=$intern->where("periodicity",$request->periodicite);
        }
        $files=$files->paginate(10);
        $fichier=$fichier->paginate(10);
        $intern=$intern->paginate(10);
        foreach($files as $file)
        {
            $opp=Acteur::on("sqlsrv")->where("id",$file->operateur_id)->first();
            if(!$opp)
                $file->name="Admin";
            else
                $file->name=$opp->nom_acteur;
        }
        foreach($intern as $file)
        {
            $opp=Acteur::on("sqlsrv")->where("id",$file->operateur_id)->first();
            if(!$opp)
                $file->name="Admin";
            else
                $file->name=$opp->nom_acteur;
        }
        foreach($fichier as $file)
        {
            $opp=Acteur::on("sqlsrv")->where("id",$file->acteur_id)->first();
            if(!$opp)
                $file->name="Admin";
            else
                $file->name=$opp->nom_acteur;
        }
        if($request->ajax())
            return view("pages.datapartial",["files"=>$files,"fichiers"=>$fichier,"intern"=>$intern])->render();
        $acteur=Acteur::on("sqlsrv")->orderBy("nom_acteur")->get();
        $fiches=Fiche::on("sqlsrv")->orderBy("name")->get();
        return view("pages.data",["files"=>$files,"intern"=>$intern,"acteurs"=>$acteur,"fichiers"=>$fichier,"fiches"=>$fiches]);

    }
    public function renvoyer(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        if($request->type==="formulaire")
            $fichier=submission::on("mysql")->where("id",$request->id)->first();
        if($request->type==="fichier")
            $fichier=SubmissionExcel::on("mysql")->where("id",$request->id)->first();
        if(!$fichier)
            return redirect()->back()->with("error","Soumission inexistante !");
        if($fichier->type==="refaire")
            return redirect()->back()->with("error","Soumission déja renvoyé !");

        $fichier->type="refaire";
        $fichier->setConnection("mysql")->save();
        event(new RenvoiFiche($fichier,$request->type));
        if($request->type==="formulaire")
            $comm= new Commentaire();
        else
            $comm= new CommentaireExcel();
        $comm->comment=$request->commentaire;
        $comm->type="admin";
        $comm->submission_id=$request->id;
        $comm->setConnection("mysql")->save();
        return redirect()->back()->with(["success"=>"Formulaire ".$request->formName."correctement renvoyé à l'opérateur ".$request->acteurName." !"]);
    }
    public function admin(Request $request)
    {   if($request->has("name"))
            $admins=User::on('sqlsrv')->where("name",'like', '%' . $request->name . '%')->orWhere("email",'like', '%' . $request->name . '%')->paginate(10);
        else
            $admins= User::on('sqlsrv')->paginate(10);
        foreach($admins as $admin)
        {
            if($admin->role==="1")
                $admin->roleName="Super Admin";
            else
                $admin->roleName=Role::on("sqlsrv")->find($admin->role)->name;
        }
        if ($request->ajax()) {
            return view('pages.adminpartial', compact('admins'))->render();
        }
        $roles=Role::on("sqlsrv")->get();
        return view('pages.admin',['admins'=>$admins,"roles"=>$roles]);
    }
    public function adminCreate(Request $request)
    {   if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"a"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de créer des administrateurs !");

    }
        $role=$request->input("role");
        $name=$request->input("name");
        $email=$request->input("email");
        $user1=User::on('sqlsrv')->where("email",$email)->first();
        if($user1)
            return redirect()->back()->with('error','Email utilisé !');
        if($role==="1" && auth()->user()->role!=="1")
            return redirect()->back()->with('error','Vous ne pouvez pas créer un super admin en tantque admin !');
        $user= new User();
        $user->name=$name;
        $user->email=$email;
        $user->role=$role;
        $user->operateur_id=0;
        $token = Password::broker()->createToken($user);
        $opp="";
        $resetUrl = env('APP_URL') . route('password.reset', ['token' => $token, 'email' => $user->email], false);
        Mail::to($user->email)->send(new AdminPasswordResetNotification($opp,$resetUrl));
        $user->timestamps=false;
        $user->created_at=Carbon::now()->format('Ymd H:i:s');
        $user->setConnection('sqlsrv')->save();
        $user->timestamps=true;
        return redirect()->back()->with('success','Administrateur ajouté !');
    }
    public function adminDelete(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"a"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de supprimer des administrateurs !");

    }
        $id=$request->input("idUser");
        if(!$id)
            return redirect()->back()->with('error','Aucun id!');
        if((int)$id==auth()->user()->id)
            return redirect()->back()->with('error','Vous ne pouvez pas supprimé votre compte !');
        $user=User::on('sqlsrv')->where("id",$id)->first();
        if($user->role==="1" && auth()->user()->role!=="1")
            return redirect()->back()->with('error','Vous ne pouvez pas supprimé un super admin en tantque admin !');
        $user->setConnection('sqlsrv')->delete();
        return redirect()->back()->with('success','Administrateur supprimé !');

    }
    public function adminUpdate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"a"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modifier des administrateurs !");

    }
        $id=$request->input("id");
        $role=$request->input("role");
        $name=$request->input("name");
        $email=$request->input("email");
        $user=User::on('sqlsrv')->where("email",$email)->where("id","!=",$id)->first();
        if($user)
            return redirect()->back()->with('error','Email utilisé !');
        $user=User::on('sqlsrv')->where("id",$id)->first();
        if(!$user)
            return redirect()->back()->with('error','Administrateur introuvable !');
        if(($role==="1" || $user->role==="1") && auth()->user()->role!=="1")
            return redirect()->back()->with('error','Vous ne pouvez pas modifier un super admin !');
        $user->name=$name;
        $user->email=$email;
        $user->role=$role;
        $user->timestamps=false;
        $user->updated_at=Carbon::now()->format('Ymd H:i:s');
        $user->setConnection('sqlsrv')->save();
        $user->timestamps=true;
        return redirect()->back()->with('success','Administrateur modifié !');
    }
    public function dashboard(Request $request)
    {
        $dashboard=Dashboard::on("sqlsrv");
        if($request->name)
            $dashboard=$dashboard->where("name","like",'%'.$request->name."%")->orWhere("lien","like","%".$request->name."%");
        if($request->visible)
            $dashboard=$dashboard->where("visible",$request->visbile);
        $dashboard=$dashboard->paginate(10);
        if ($request->ajax()) {
            return view('pages.dashboardpartial', compact('dashboard'))->render();
        }
        return view('pages.dashboard',['dashboard'=>$dashboard,]);
    }
    public function dashboardCreate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"c"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de création !");

    }
        $dashboard=Dashboard::on("sqlsrv")->where("name",$request->name)->first();
        if($dashboard){
            return redirect()->back()->with("error","Nom déja utilisé !");
        }
        $dashboard =new Dashboard();
        $dashboard->lien=$request->lien;
        $dashboard->visible=$request->visible;
        $dashboard->name=$request->name;
        $dashboard->timestamps=false;
        $dashboard->created_at=Carbon::now()->format('Ymd H:i:s');
        $dashboard->setConnection("sqlsrv")->save();
        $dashboard->timestamps=true;
        return redirect()->back()->with("success","Dashboard crée !");
    }
    public function dashboardUpdate(Request $request)
    {
        if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        $dashboard=Dashboard::on("sqlsrv")->where("id",$request->id)->first();
        if(!$dashboard)
        {
            return redirect()->back()->with("error","Dashboard introuvable !");
        }
        $dashboard1=Dashboard::on("sqlsrv")->where("name",$request->name)->whereNot("id",$request->id)->first();
        if($dashboard1){
            return redirect()->back()->with("error","Nom déja utilisé !");
        }
        $dashboard->lien=$request->lien;
        $dashboard->visible=$request->visible;
        $dashboard->name=$request->name;
        $dashboard->timestamps=false;
        $dashboard->updated_at=Carbon::now()->format('Ymd H:i:s');
        $dashboard->setConnection("sqlsrv")->save();
        $dashboard->timestamps=true;
        return redirect()->back()->with("success","Dashboard mise à jour !");
    }
    public function dashboardDelete(Request $request)
    {   if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"d"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de suppression !");

    }
        $dashboard=Dashboard::on("sqlsrv")->where("id",$request->idDashboard)->first();
        if(!$dashboard)
        {
            return redirect()->back()->with("error","Dashboard introuvable !");
        }
        $dashboard->setConnection("sqlsrv")->delete();
        return redirect()->back()->with("success","Dashboard supprimée !");
    }
    public function dashboardDisplay(Request $request)
     {
        $dashboard=Dashboard::on("sqlsrv");
        if($request->name)
            $dashboard=$dashboard->where("name","like",'%'.$request->name."%")->orWhere("lien","like","%".$request->name."%");
        $dashboard=$dashboard->where("visible","oui")->paginate(8);
        if ($request->ajax()) {
                return view('pages.dashboardDisplaypartial', compact('dashboard'))->render();
            }
            return view('pages.dashboardDisplay',['dashboard'=>$dashboard,]);
     }
     public function roles(Request $request)
     {  if(auth()->user()->role!=="1")
            return redirect()->back()->with("error","Vous n'avez le droit d'accéder à la page Roles");
        $roles=Role::on("sqlsrv");
        if($request->name)
            $roles=$roles->where("name","like","%".$request->name."%");
        $roles=$roles->paginate(10);
        if($request->ajax()){
            return view("pages.rolespartial",compact("roles"))->render();
        }
        return view("pages.roles",["roles"=>$roles]);
     }
     public function roleCreate(Request $request)
     {
        if(!$request->name||!$request->create || !$request->update || !$request->delete || !$request->admin)
            return redirect()->back()->with("error","Tous le champs sont obligatoires !");
        $role=Role::on("sqlsrv")->where("name",$request->name)->first();
        if($role)
        return redirect()->back()->with("error","Nom déja existant !");
        $privilege="";
        if($request->create==="oui")
            $privilege.="c";
        if($request->update==="oui")
            $privilege.="u";
        if($request->delete==="oui")
            $privilege.="d";
        if($request->admin==="oui")
            $privilege.="a";
        $role=new Role();
        $role->name=$request->name;
        $role->privilege=$privilege;
        $role->timestamps=false;
        $role->created_at=Carbon::now()->format('Ymd H:i:s');
        $role->setConnection("sqlsrv")->save();
        $role->timestamps=true;
        return redirect()->back()->with("success","Role créer avec succès !");
    }
    public function roleUpdate(Request $request)
     {
        if(!$request->name||!$request->create || !$request->update || !$request->delete || !$request->admin)
            return redirect()->back()->with("error","Tous le champs sont obligatoires !");
        $role=Role::on("sqlsrv")->where("name",$request->name)->whereNot("id",$request->id)->first();
        if($role)
            return redirect()->back()->with("error","Nom déja existant !");
        $privilege="";
        if($request->create==="oui")
            $privilege.="c";
        if($request->update==="oui")
            $privilege.="u";
        if($request->delete==="oui")
            $privilege.="d";
        if($request->admin==="oui")
            $privilege.="a";
        $role=Role::on("sqlsrv")->find($request->id);
        $role->name=$request->name;
        $role->privilege=$privilege;
        $role->timestamps=false;
        $role->updated_at=Carbon::now()->format('Ymd H:i:s');
        $role->setConnection("sqlsrv")->save();
        $role->timestamps=true;
        return redirect()->back()->with("success","Role mis à jour avec succès !");
    }
    public function roleDelete(Request $request)
     {
        if(!$request->id)
            return redirect()->back()->with("error","Erreur !");
        $role=User::on("sqlsrv")->where("role",$request->id)->first();
        if($role)
            return redirect()->back()->with("error","Role affécté à un utilisateur !");

        $role=Role::on("sqlsrv")->find($request->id);
        $role->setConnection("sqlsrv")->delete();
        return redirect()->back()->with("success","Role supprimer avec succès !");
    }
}
