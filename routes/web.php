<?php

use Illuminate\Support\Facades\Route;
use App\Models\FormExcel;
use App\Models\SubmissionExcel;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);


  Route::middleware(['auth','web'])->group(function () {
    Route::get('/home',function(){return view("layouts.app");})->name('home');
        Route::get('/users', [App\Http\Controllers\adminController::class, 'user'])->name('user');
        Route::post('/user/create', [App\Http\Controllers\adminController::class,'userCreate'])->name('user.create');
        Route::post('/user/delete', [App\Http\Controllers\adminController::class,'userDelete'])->name('user.delete');
        Route::post('/user/update', [App\Http\Controllers\adminController::class,'userUpdate'])->name('user.update');

        Route::get('/admins', [App\Http\Controllers\sqlServerController::class, 'admin'])->name('admin');
        Route::post('/admin/create', [App\Http\Controllers\sqlServerController::class,'adminCreate'])->name('admin.create');
        Route::post('/admin/delete', [App\Http\Controllers\sqlServerController::class,'adminDelete'])->name('admin.delete');
        Route::post('/admin/update', [App\Http\Controllers\sqlServerController::class,'adminUpdate'])->name('admin.update');

        Route::get('/acteurs', [App\Http\Controllers\adminController::class, 'acteur'])->name('acteur');
        Route::post('/acteur/create', [App\Http\Controllers\adminController::class, 'acteurCreate'])->name('acteur.create');
        Route::post('/acteur/delete', [App\Http\Controllers\adminController::class, 'acteurDelete'])->name('acteur.delete');
        Route::post('/acteur/update', [App\Http\Controllers\adminController::class, 'acteurUpdate'])->name('acteur.update');

        Route::get('/domaines', [App\Http\Controllers\adminController::class, 'domaine'])->name('domaine');
        Route::post('/domaine/create', [App\Http\Controllers\adminController::class, 'domaineCreate'])->name('domaine.crate');
        Route::post('/domaine/delete', [App\Http\Controllers\adminController::class, 'domaineDelete'])->name('domaine.delete');
        Route::post('/domaine/update', [App\Http\Controllers\adminController::class, 'domaineUpdate'])->name('domaine.update');

        Route::get('/fiches', [App\Http\Controllers\adminController::class, 'fiche'])->name('fiche');
        Route::post('/fiche/create', [App\Http\Controllers\adminController::class, 'ficheCreate'])->name('fiche.create');
        Route::post('/fiche/delete', [App\Http\Controllers\adminController::class, 'ficheDelete'])->name('fiche.delete');
        Route::post('/fiche/update', [App\Http\Controllers\adminController::class, 'ficheUpdate'])->name('fiche.update');

        Route::get("/fiches/{id}",[App\Http\Controllers\adminController::class, 'ficheDetails'])->name("fiche.detail");

        Route::post("/formulaires",[App\Http\Controllers\adminController::class, 'formulaire'])->name("formulaire");
        Route::post("/formulairesCopie",[App\Http\Controllers\adminController::class, 'formulaireCopie'])->name("formulaire.copie");
        Route::post("/formulairesUpdate",[App\Http\Controllers\adminController::class, 'formulaireUpdateView'])->name("formulaire.updateView");
        Route::post("/formulaire/create",[App\Http\Controllers\adminController::class, 'formulaireCreate'])->name("formulaire");
        Route::post('/formulaire/delete', [App\Http\Controllers\adminController::class, 'formulaireDelete'])->name('formulaire.delete');
        Route::post('/formulaire/update', [App\Http\Controllers\adminController::class, 'formulaireUpdate'])->name('formulaire.update');

        Route::post("/file/create",[App\Http\Controllers\fileController::class, 'fileCreate'])->name("file.create");
        Route::post('/file/delete', [App\Http\Controllers\adminController::class, 'fichierDelete'])->name('file.delete');
        Route::post('/file/update', [App\Http\Controllers\fileController::class, 'fileUpdate'])->name('file.update');
        Route::get('/file/download', [App\Http\Controllers\fileController::class, 'download'])->name('file.download');
    Route::get('/file/download2', function (Request $request) {
        if($request->type==="submission")
        {
            $data=SubmissionExcel::on("mysql")->find($request->id);
            if($data)
                {   $name=FormExcel::on("mysql")->find($data->form_id)->name;
                    $data->name=$name."_".$data->periodicity."_".$data->year;
                }
        }
        else if($request->type==="data")
        {
            $data=SubmissionExcel::on("sqlsrv")->find($request->id);
            if($data)
                {   $name=FormExcel::on("sqlsrv")->find($data->form_id)->name;
                    $data->name=$name."_".$data->periodicity."_".$data->year;
                }
        }
        else if($request->type==="form1")
        {
            $data = FormExcel::on("sqlsrv")->find($request->id);
        }
        else
        $data = FormExcel::on("mysql")->find($request->id);
        if ($data) {
        $file_contents=$data->excel;
        $type = "xlsx";
        $mime= 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        if ($data->mime === 'application/vnd.ms-excel' || $data->mime === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'||$request->type==="data") {
            if ($data->mime === 'application/vnd.ms-excel') {
            $type = "xls";
            $mime='application/vnd.ms-excel';
            }
        }
            return response($file_contents)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', $mime)
            ->header('Content-length', strlen($file_contents))
            ->header('Content-Disposition', 'attachment; filename=' . $data->name . '.' . $type)
            ->header('Content-Transfer-Encoding', 'binary');

        }

        return response()->json(['error' => 'No data found.']);
    })->name('file.download2');
        Route::post("/sendMail",[App\Http\Controllers\adminController::class, 'sendMail'])->name("email.send");
        Route::get('/system',[App\Http\Controllers\adminController::class, 'system']);
        Route::get('/periodicite',[App\Http\Controllers\adminController::class, 'periodicite']);
        Route::post("/changeValid",[App\Http\Controllers\adminController::class, 'changeValid']);
        Route::post("/changeYear",[App\Http\Controllers\adminController::class, 'changeYear']);
        Route::get('/formules',[App\Http\Controllers\adminController::class, 'formules'] );
        Route::post("/formule/create",[App\Http\Controllers\adminController::class, 'formulesCreate'])->name("formules.create");
        Route::post("/formule/update",[App\Http\Controllers\adminController::class, 'formulesUpdate'])->name("formules.update");
        Route::post("/formule/delete",[App\Http\Controllers\adminController::class, 'formulesDelete'])->name("formules.delete");
        Route::get("/getEveryForm/{id}",[App\Http\Controllers\adminController::class, 'getEveryForm']);
        Route::get("/getEveryFormSqlsrv/{id}",[App\Http\Controllers\adminController::class, 'getEveryFormSql']);
        Route::post("/renvoiSub",[App\Http\Controllers\sqlServerController::class, 'renvoyer'])->name("renvoi");
        Route::post("/checkPassword",[App\Http\Controllers\sqlServerController::class, 'checkPassword'])->name("check.password");
        Route::post('/setType', [App\Http\Controllers\adminController::class, 'setType']);
        Route::post('/destroyBrou', [App\Http\Controllers\adminController::class, 'destroyBrou']);
        Route::post('/reouvrirForm', [App\Http\Controllers\adminController::class, 'reouvrir'])->name("formulaire.reouvrir");
        Route::post('/setBrou', [App\Http\Controllers\adminController::class, 'setBrou']);
        Route::post('/setInt', [App\Http\Controllers\adminController::class, 'setInt']);
        Route::get('/suivi', [App\Http\Controllers\adminController::class, 'suivi'])->name("suivi");
        Route::post('/deleteType', [App\Http\Controllers\adminController::class, 'deleteType']);
        Route::get("/data",[App\Http\Controllers\sqlServerController::class, 'submissionData'])->name("data");
        Route::get("/dataCloud",[App\Http\Controllers\adminController::class, 'dataCloud']);
        Route::post("/formulaire/saisie",[App\Http\Controllers\adminController::class, 'formulesSaisie'])->name("formulaire.saisie");
        Route::get("/getPeriodicite",[App\Http\Controllers\adminController::class, 'getPeriodicite']);
        Route::get("/getPeriodicite2",[App\Http\Controllers\adminController::class, 'getPeriodicite2']);
        Route::post("/changeUser",[App\Http\Controllers\sqlServerController::class, 'updateUser'])->name("changeUser");
        Route::post("/changePicture",[App\Http\Controllers\sqlServerController::class, 'changePicture'])->name("changePicture");
                Route::get("/profile",function()
        {
            return view("pages.profile");
        });
        Route::get("/500-page-error",function()
        {
            return view("errors.500");
        });
        Route::get("/soumissions",[App\Http\Controllers\sqlServerController::class, 'soumission']);
        Route::get("/soumission/intern",[App\Http\Controllers\AdminController::class, 'soumissionIntern']);
        Route::get("/soumission/{id}/{acteur}",[App\Http\Controllers\AdminController::class, 'soumission']);
        Route::post("/soumissionCU",[App\Http\Controllers\sqlServerController::class, 'soumissionCU']);
        Route::get("/",[App\Http\Controllers\sqlServerController::class, 'dashboardDisplay']);
        Route::get("/dashboards",[App\Http\Controllers\sqlServerController::class, 'dashboard']);
        Route::post("/dashboardCreate",[App\Http\Controllers\sqlServerController::class, 'dashboardCreate'])->name("dashboard.create");
        Route::post("/dashboardUpdate",[App\Http\Controllers\sqlServerController::class, 'dashboardUpdate'])->name("dashboard.update");
        Route::post("/dashboardDelete",[App\Http\Controllers\sqlServerController::class, 'dashboardDelete'])->name("dashboard.delete");
        Route::post("/logoModify",[App\Http\Controllers\ImageController::class, 'uploadImage'])->name("upload.imageLogo");
        Route::post("/pdf",[App\Http\Controllers\exportPdfExcel::class,'exportToPDF']);
        Route::post("/excel",[App\Http\Controllers\exportPdfExcel::class,'exportToExcel']);
        Route::get("/groupes",[App\Http\Controllers\adminController::class, 'group']);
        Route::post("/groupe/create",[App\Http\Controllers\adminController::class, 'groupAdd'])->name("groupe.create");
        Route::post("/groupe/update",[App\Http\Controllers\adminController::class, 'groupUpdate'])->name("groupe.update");
        Route::post("/groupe/delete",[App\Http\Controllers\adminController::class, 'groupeDelete'])->name("groupe.delete");
        Route::get("/groupes/{id}",[App\Http\Controllers\adminController::class, 'groupDetails']);
        Route::post("/groupeDetail/create",[App\Http\Controllers\adminController::class, 'groupDetailsCreate']);
        Route::post("/groupeDetail/update",[App\Http\Controllers\adminController::class, 'groupDetailsUpdate']);
        Route::post("/groupeDetail/delete",[App\Http\Controllers\adminController::class, 'groupDetailsDelete'])->name("groupeDetails.delete");
        Route::get("/getForVerification",[App\Http\Controllers\VerificationController::class, 'getThreeMonths']);
        Route::post("/submitform",[App\Http\Controllers\FormController::class,'saveForm'])->name("submitForm");
        Route::post("/verifySuper",[App\Http\Controllers\modificationController::class,'check']);
        Route::post("/modifySub",[App\Http\Controllers\modificationController::class,'update']);
        Route::get("/roles",[App\Http\Controllers\sqlServerController::class,"roles"]);
        Route::post("/role/create",[App\Http\Controllers\sqlServerController::class,"roleCreate"]);
        Route::post("/role/update",[App\Http\Controllers\sqlServerController::class,"roleUpdate"]);
        Route::post("/role/delete",[App\Http\Controllers\sqlServerController::class,"roleDelete"]);

  });


Route::post("/resetPasswordCustom",[App\Http\Controllers\Auth\ResetPasswordController::class,"resetPassword"])->name("password.customReset");
Auth::routes();

Route::get('/images/{filename}', function ($filename) {
    $path = public_path('logo_images/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    } else {
        $defaultImagePath = public_path('assets/images/logo-dark.png');
        return response()->file($defaultImagePath);
    }
});
