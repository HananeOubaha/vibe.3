<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // First try to find user by provider_id and provider
            $user = User::where('provider_id', $socialUser->getId())
                    ->where('provider', $provider)
                    ->first();

            // If not found by provider_id, try to find by email
            if (!$user) {
                $user = User::where('email', $socialUser->getEmail())->first();
            }

            // Split full name into name and prenom (first name)
            $fullName = $socialUser->getName();
            $nameParts = explode(' ', $fullName);
            $prenom = $nameParts[0] ?? ''; // First part as prenom
            $name = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : ''; // Rest as name

            if ($user) {
                // User exists - Update provider details and login
                $user->update([
                    'name' => $name ?: $user->name, // Keep existing name if new one is empty
                    'prenom' => $prenom ?: $user->prenom, // Keep existing prenom if new one is empty
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                    'profile_photo_path' => $socialUser->getAvatar() ?? $user->profile_photo_path,
                ]);

                Auth::login($user);
                return redirect()->route('dashboard')->with('status', 'Connexion réussie!');
            } else {
                // User doesn't exist - Create new account
                $newUser = User::create([
                    'name' => $name,
                    'prenom' => $prenom,
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                    'profile_photo_path' => $socialUser->getAvatar(),
                ]);

                Auth::login($newUser);

                // Redirect to a page where user can set their pseudo
                return redirect()->route('profile.show')
                    ->with('status', 'Compte créé avec succès! Veuillez compléter votre profil en ajoutant un pseudo.');
            }

        } catch (\Exception $e) {
            \Log::error('Social Auth Error: ' . $e->getMessage());
            return redirect()->route('login')
                        ->withErrors(['error' => 'Une erreur s\'est produite lors de la connexion sociale. Veuillez réessayer.']);
        }
    }
}
