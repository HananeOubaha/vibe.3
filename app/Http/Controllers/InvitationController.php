<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DemandeAmitie;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
            // Si la demande existe, la mettre à jour à "accepté" si elle est en attente et que l'utilisateur courant est le receveur
            if ($existingDemande->statut === 'en attente' && $existingDemande->utilisateur_recepteur_id == $currentUser->id) {
                $existingDemande->statut = 'accepté';
                $existingDemande->save();
                session()->flash('success', 'Ami ajouté avec succès !');
            } else {
                session()->flash('info', 'Vous êtes déjà amis ou une demande est en attente.');
            }
        } else {
            // Créer une nouvelle demande d'amitié et l'accepter automatiquement
            $demande = new DemandeAmitie();
            $demande->utilisateur_demandeur_id = $currentUser->id;
            $demande->utilisateur_recepteur_id = $user->id;
            $demande->statut = 'accepté'; // Accepter automatiquement
            $demande->save();

            session()->flash('success', 'Ami ajouté avec succès !');
        }

        // Effacer le token après utilisation (important pour la sécurité)
        $user->invitation_token = null;
        $user->invitation_expires_at = null;
        $user->save();

        return Redirect::route('profil.show', ['userId' => $userId])->with('success', 'Ami ajouté avec succès !');

    }

    public function generateInvitationLink(User $user)
    {
        $token = Str::random(40); // Génère un token aléatoire
        $user->invitation_token = $token;
        $user->invitation_expires_at = Carbon::now()->addHour(); // Expiration dans 1 heure
        $user->save();
        return route('invitation.accept', ['userId' => $user->id, 'token' => $token]);
    }
}
