<?php 

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;

class UpdateUserOfflineStatus
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;
        
        if ($user) {
            $user->update(['is_online' => false]); // Mettre à jour le statut
        }
    }
}
