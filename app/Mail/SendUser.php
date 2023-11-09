<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\File;

class SendUser extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $attachment;

    public function __construct($subject, $message, $attachment)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->attachment = $attachment;
    }

    public function build()
    {
        $var=$this->subject($this->subject)
            ->view('email.send')
            ->with(['contenu' => $this->message]);
        if($this->attachment!==null)
        $var=$var->attach($this->attachment->getRealPath(), [
            'as' => $this->attachment->getClientOriginalName(),
            'mime' => $this->attachment->getClientMimeType(),
        ]);
        return($var);
    }

}
