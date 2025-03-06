<?php

namespace App\Jobs;

use App\Events\MessageSent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Notifications\NewMessageNotification;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sender;
    protected $receiver;
    protected $message;

    public function __construct($sender, $receiver, $message)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->message = $message;
    }

    public function handle(): void
    {

//        event(new MessageSent($this->sender, $this->message, $this->receiver->id));
        // Envoyer une notification au destinataire
        $this->receiver->notify(new NewMessageNotification($this->sender, $this->message));
    }
}
