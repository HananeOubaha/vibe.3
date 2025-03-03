<?php

namespace App\Http\Controllers;
use App\Models\Like;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likePost($postId)
    {
        $user = auth()->user();

        $existingLike = Like::where('post_id', $postId)
            ->where('user_id', $user->id)
            ->first();
        if ($existingLike) {
            $existingLike->delete();
            return back()->with('error', 'Vous avez déjà liké ce post.');
        }
        Like::create([
            'post_id' => $postId,
            'user_id' =>  $user->id,
        ]);

        return back()->with('success', 'Post liké avec succès !');
    }

    public function unlikePost($postId)
    {
        $user = auth()->user();

        $like = Like::where('post_id', $postId)
            ->where('user_id', $user->id)
            ->first();

        if (!$like) {
            return back()->with('error', 'Vous n\'avez pas encore liké ce post.');
        }

        $like->delete();
        return back()->with('success', 'Like retiré avec succès.');
    }
}
