<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DemandeAmitie;
use App\Models\messages; // Assurez-vous d'importer le modèle messages
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Chatify\Facades\Chatify;

class InvitationController extends Controller
{
    public function accept(Request $request, $userId, $token)
    {
        $user = User::find($userId);
        $currentUser = Auth::user();

        if (!$user || $user->invitation_token !== $token || Carbon::now()->greaterThan($user->invitation_expires_at)) {
            abort(403, 'Lien d\'invitation invalide ou expiré.');
        }

        // Vérifier si une demande existe déjà (dans les deux sens)
        $existingDemande = DemandeAmitie::where(function ($query) use ($currentUser, $user) {
            $query->where('utilisateur_demandeur_id', $currentUser->id)
                ->where('utilisateur_recepteur_id', $user->id);
        })->orWhere(function ($query) use ($currentUser, $user) {
            $query->where('utilisateur_demandeur_id', $user->id)
                ->where('utilisateur_recepteur_id', $currentUser->id);
        })->first();

        if ($existingDemande) {
            if ($existingDemande->statut === 'en attente' && $existingDemande->utilisateur_recepteur_id == $currentUser->id) {
                $existingDemande->statut = 'accepté';
                $existingDemande->save();
                session()->flash('success', 'Ami ajouté avec succès !');
            } else {
                session()->flash('info', 'Vous êtes déjà amis ou une demande est en attente.');
            }
        } else {
            $demande = new DemandeAmitie();
            $demande->utilisateur_demandeur_id = $currentUser->id;
            $demande->utilisateur_recepteur_id = $user->id;
            $demande->statut = 'accepté';
            $demande->save();

            session()->flash('success', 'Ami ajouté avec succès !');
        }

        $user->invitation_token = null;
        $user->invitation_expires_at = null;
        $user->save();

        // Rediriger vers la conversation Chatify
        return Redirect::to('/chatify/'.$userId)->with('success', 'Ami ajouté et conversation démarrée !');
    }

    public function generateInvitationLink(User $user)
    {
        $token = Str::random(40);
        $user->invitation_token = $token;
        $user->invitation_expires_at = Carbon::now()->addHour();
        $user->save();
        return route('invitation.accept', ['userId' => $user->id, 'token' => $token]);
    }

       private function startConversation($userId1, $userId2)
    {
       // 1. Vérifiez si une conversation existe déjà entre les deux utilisateurs
       $existingConversation = $this->getExistingConversation($userId1, $userId2);

       if ($existingConversation) {
           // Retournez l'ID de la conversation existante
           return $existingConversation->id;
       }

       // 2. Si aucune conversation n'existe, créez-en une nouvelle
       $newConversation = $this->createNewConversation($userId1, $userId2);

       // 3. Retournez l'ID de la nouvelle conversation
       return $newConversation->id;
    }

    // Helper function pour vérifier si une conversation existe déjà
    private function getExistingConversation($userId1, $userId2)
    {
         return messages::where(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId1)
                  ->where('receiver_id', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId2)
                  ->where('receiver_id', $userId1);
        })->first();
    }

    // Helper function pour créer une nouvelle conversation
    private function createNewConversation($userId1, $userId2)
    {
          $message = messages::create([
            'conversation_id' => Str::uuid(),
            'sender_id' => $userId1,
            'receiver_id' => $userId2,
            'message' => "Salut! Nouvelle conversation initiée via QR code.", // Message initial
        ]);

        return (object) ['id' => $message->conversation_id];
    }
}
