<?php
namespace App\Listeners;

use App\Events\FicheCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminPasswordResetNotification;
use App\Mail\NewFicheNotification;
use App\Models\User;
class SendFicheCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(FicheCreated $event)
    {
        $file = $event->file;
        $array = json_decode($file->operateur, true);
        $users=[];
        foreach($array as $id)
        {
            $user=User::on("mysql")->where("operateur_id",$id)->first();
            if($user)
                $users[]=$user->email;
        }
        if(!empty($users))
        Mail::bcc($users)->send(new NewFicheNotification($file->name));
    }
}