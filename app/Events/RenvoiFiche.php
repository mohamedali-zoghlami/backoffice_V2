<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RenvoiFiche
{
    use Dispatchable, SerializesModels;

    public $file;
    public $table;
    public function __construct($file,$table)
    {
        $this->file = $file;
        $this->table=$table;
    }
}