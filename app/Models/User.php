<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pseudo',
        'prenom',
        'bio',
        'is_online',
        'last_seen',
        'invitation_token', // Ajout du token
        'invitation_expires_at', // Ajout de la date d'expiration
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'invitation_expires_at' => 'datetime', // Ajout du cast pour la date
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function amisEnvoyes()
    {
        return $this->belongsToMany(User::class, 'demande_amitie', 'utilisateur_demandeur_id', 'utilisateur_recepteur_id')
            ->wherePivot('statut', 'accepté');
    }

    public function amisRecus()
    {
        return $this->belongsToMany(User::class, 'demande_amitie', 'utilisateur_recepteur_id', 'utilisateur_demandeur_id')
            ->wherePivot('statut', 'accepté');
    }


    public function postes(){
        return $this->hasMany(Post::class,'auteur_id');
    }
    // public function isOnline()
    // {
    //     return $this->last_seen && $this->last_seen->diffInMinutes(Carbon::now()) < 1;
    // }


    public function isOnline()
{
    return $this->is_online; // Retourne true si l'utilisateur est en ligne
}


}
