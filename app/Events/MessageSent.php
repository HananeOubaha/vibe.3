<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $receiver_id;

    public function __construct(User $user, $message, $receiver_id)
    {
        $this->user = $user;
        $this->message = $message;
        $this->receiver_id = $receiver_id;
    }

    public function broadcastOn()
    {
        Log::info("📢 MessageSent event triggered for receiver {$this->receiver_id} from user {$this->user->id}");

        return new PrivateChannel('chat.' . $this->receiver_id);
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'message' => $this->message,
            'receiver_id' => $this->receiver_id
        ];
    }



}
