<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Profile extends Component
{
    public $user;

    public function mount($userId)
    {
        $this->user = User::with('postes')->findOrFail($userId);

    }

    public function render()
    {
        return view('livewire.profile', [
            'posts' => $this->user->postes
        ])->layout('layouts.app');
    }
}

