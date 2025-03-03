<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AmisController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentaireController;

use App\Livewire\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'), 'verified',
])->group(function () {

    Route::get('/demandes', [AmisController::class, 'afficherDemandesAmitie'])->name('afficherDemandesAmitie');
    Route::post('/envoyer-demande-amitie/{utilisateur_recepteur_id}', [UserController::class, 'envoyerDemandeAmitie'])->name('envoyerDemandeAmitie');
    Route::get('/Search', [UserController::class, 'search'])->name('Search');

    Route::post('/accepter-demande/{id}', [AmisController::class, 'accepterDemandeAmitie'])->name('accepterDemandeAmitie');
    Route::delete('/refuser-demande/{id}', [AmisController::class, 'refuserDemandeAmitie'])->name('refuserDemandeAmitie');
    Route::delete('/anuller-demande/{id}', [AmisController::class, 'AnnulerDemandeAmitie'])->name('AnnulerDemandeAmitie');
    Route::get('/list-Amis', [AmisController::class, 'showallamisaccepter'])->name('showallamis');

// Routes pour les publication
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/update/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

// Routes pour les commontaire
    Route::post('commentaires/Store', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::delete('commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');


// Routes pour les likes
    Route::post('likePost/{id}', [LikeController::class, 'likePost'])->name('likePost');

//profile
    Route::get('/profil/{userId}', Profile::class)->name('profil.show');

    Route::get('/profile/posts', [PostController::class, 'profile_auth'])->name('posts.profile');

});


