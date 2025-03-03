<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Like;
use App\Models\Commentaire;
use App\Models\User;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'auteur_id',
        'contenu',
        'image',
        'datePublication',
    ];

    /**
     * Relation avec l'utilisateur (Auteur du post).
     */
    public function auteur(){
        return $this->belongsTo(User::class, 'auteur_id');
    }


    public function likes(){
        return $this->hasMany(Like::class);
    }


    public function comments()
    {
        return $this->hasMany(Commentaire::class);
    }

//    public function shares()
//    {
//        return $this->hasMany(Share::class);
//    }
}

