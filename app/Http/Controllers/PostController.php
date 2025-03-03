<?php
namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\DemandeAmitie;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    public function index()
    {
        $utilisateur = auth()->user();
        $demandesRecues=DemandeAmitie::where('utilisateur_recepteur_id', $utilisateur->id)
            ->where('statut', 'en attente')
            ->with('receveur')
            ->get();
        $comments= Commentaire::all();
        $likes= Like::all();

        $amisIds = DemandeAmitie::where(function ($query) use ($utilisateur) {
            $query->where('utilisateur_demandeur_id', $utilisateur->id)
                ->orWhere('utilisateur_recepteur_id', $utilisateur->id);
        })
            ->where('statut', 'accepté')
            ->pluck('utilisateur_demandeur_id', 'utilisateur_recepteur_id')
            ->flatten()
            ->unique()
            ->filter(fn ($id) => $id != $utilisateur->id);

        $amisIds->push($utilisateur->id);

        $posts = Post::whereIn('auteur_id', $amisIds)
            ->with(['auteur', 'likes', 'comments.user'])
            ->orderBy('datePublication', 'desc')
            ->get();

        $amis = $utilisateur->amisEnvoyes->merge($utilisateur->amisRecus);

        return view('dashboard', compact('posts','demandesRecues','comments','likes','amis'));
    }



    public function profile_auth()
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }
        $posts = Post::with(['auteur', 'likes', 'comments.user'])
            ->where('auteur_id', $user->id)
            ->orderBy('datePublication', 'desc')
            ->get();

        return view('profile.update-profile-information-form', [
            'posts' => $posts
        ]);
    }


    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'contenu' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        Post::create([
            'auteur_id' => $user->id,
            'contenu' => $request->contenu,
            'image' => $imagePath,
            'datePublication'=>Carbon::now()

        ]);
        return redirect()->back()->with('success', 'Post créé avec succès !');
    }

//    public function edit($id)
//    {
//        $post = Post::findOrFail($id);
//        return view('edit', compact('post'));
//    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $post = Post::findOrFail($id);

        if ($post->auteur_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'avez pas l\'autorisation de modifier ce post.');
        }

        $request->validate([
            'contenu' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'contenu' => $request->contenu,
            'datePublication' => Carbon::now(),
            'image' => $post->image,
        ]);
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Post mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $user = auth()->user();
        if ($post->auteur_id !== $user->id) {
            return redirect()->back()->with('error', 'Vous n\'avez pas l\'autorisation de supprimer ce post.');
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès.');
    }
}
