<?php
namespace App\Listeners;

use App\Events\RenvoiFiche;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminPasswordResetNotification;
use App\Mail\newRenvoiNotification;
use App\Models\User;
use App\Models\FormSave;
use App\Models\FormExcel;
use App\Models\FormPdf;

class SendRenvoiFicheNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(RenvoiFiche $event)
    {
        $file = $event->file;

        $user=User::on("mysql")->where("id",$file->user_id)->first();
        if($user)
            {   if($event->table==="formulaire")
                    $form=FormSave::on("mysql")->where("id",$file->form_id)->first();
                else if($event->table==="pdf")
                    $form=FormPdf::on("mysql")->where("id",$file->form_id)->first();
                else
                    $form=FormExcel::on("mysql")->where("id",$file->form_id)->first();
                if($form)
                {
                $data=new \stdClass();
                $data->name=$form->name;
                $data->periodicite=$file->periodicity." - ".$file->year;
                $data->user_name=$user->name;
                $data->id=$form->fiche_id;
                Mail::to($user->email)->send(new newRenvoiNotification($data));
                }
            }
    }
}
