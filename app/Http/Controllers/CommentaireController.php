<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function showallcomment(){
        $comments= Commentaire::all();
//        dd($comments);
        return redirect('commentaires',compact('comments'));
    }

    public function store(Request $request)
    {
//        if (Commentaire::where('id', $request->id)
//            ->exists()) {
//            return back()->withErrors(['error' => 'conmment déjà envoyée. !']);
//        }
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'contenu' => 'required|string|max:1000',
        ]);
        $user = auth()->user();

        Commentaire::create([
            'post_id' => $request->post_id,
            'auteur' => $user->id,
            'contenu' => $request->contenu,
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès !');
    }

    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $user = auth()->user();
        if ($commentaire->auteur !== $user->id) {
            return back()->with('error', 'Vous n\'avez pas le droit de supprimer ce commentaire.');
        }
        $commentaire->delete();
        return back()->with('success', 'Commentaire supprimé.');
    }


}
