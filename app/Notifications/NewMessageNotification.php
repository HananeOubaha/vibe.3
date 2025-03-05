<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sender;
    protected $message;

    public function __construct($sender, $message)
    {
        $this->sender = $sender;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau message reçu')
            ->greeting("Bonjour " . $notifiable->name . ",")
            ->line("Vous avez reçu un nouveau message de " . $this->sender->name)
            ->line("Message: " . $this->message)
            ->action('Voir le message', url('/chat'))
            ->line('Merci d’utiliser notre application !');
    }

    public function toArray($notifiable)
    {
        return [
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message' => $this->message,
        ];
    }
}
