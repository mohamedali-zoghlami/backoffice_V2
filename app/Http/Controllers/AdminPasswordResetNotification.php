<?php

namespace App\Http\Controllers;
use Illuminate\Mail\Mailable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AdminPasswordResetNotification extends Mailable
{
    private $operateur;
    private $resetUrl;
    public function __construct($operateur,$resetUrl)
    {
        $this->operateur = $operateur;
        $this->resetUrl= $resetUrl;
    }

    public function build()
    {
        if($this->operateur!=="")
        return  $this->subject('Mot de passe')
                ->view('email.user')
                ->with([
                    'resetUrl' => $this->resetUrl,
                    'operateur'=> $this->operateur
                ]);
        else
                $this->subject('Initialiser votre mot de passe')
                ->view('email.admin')
                ->with([
                    'resetUrl' => $this->resetUrl,

                ]);
    }
}
