<?php

namespace App\Http\Controllers;
use App\Models\DemandeAmitie;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{

    public function search(Request $request)
    {
        $users = [];

        if ($request->has('query')) {
            $query = $request->input('query');
            $users = User::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('prenom', 'LIKE', "%{$query}%")
                ->orWhere('pseudo', 'LIKE', "%{$query}%")
                ->get();
        }
        return response()->json($users);
    }

    public function envoyerDemandeAmitie($utilisateur_recepteur_id)
    {
        $utilisateur_demandeur = auth()->user();
        if (DemandeAmitie::where('utilisateur_demandeur_id', $utilisateur_demandeur->id)
            ->where('utilisateur_recepteur_id', $utilisateur_recepteur_id)
            ->exists()) {
            return back()->withErrors(['error' => 'Demande déjà envoyée. !']);
        }
        $demande = new DemandeAmitie();
        $demande->utilisateur_demandeur_id = $utilisateur_demandeur->id;
        $demande->utilisateur_recepteur_id = $utilisateur_recepteur_id;
        $demande->envoyer();
        return back()->with('success', 'Demande ajouté avec succès !');

    }



//    public function show($id)
//    {
//        $user = User::findOrFail($id);
//        return view('profile', compact('user'));
//    }


}
