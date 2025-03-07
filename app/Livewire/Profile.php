<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Http\Controllers\InvitationController;

class Profile extends Component
{
    public $user;
    public $posts; // Assurez-vous d'avoir cette propriété si vous l'utilisez dans la vue

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::with('postes')->findOrFail($userId);
        $this->posts = $this->user->postes; // Récupérez les posts ici pour les avoir disponibles dans la vue
    }

    public function render()
    {
        return view('livewire.profile', [
            'user' => $this->user, // Passez l'utilisateur à la vue
            'posts' => $this->posts, // Passez les posts à la vue
        ])->layout('layouts.app');
    }

    public function generateInvitationLink()
    {
        $invitationController = new InvitationController();
        return $invitationController->generateInvitationLink($this->user);
    }
}
