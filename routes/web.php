<?php

use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmisController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

use App\Http\Controllers\CustomChatifyController;

use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\CommentaireController;


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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/demandes', [AmisController::class, 'afficherDemandesAmitie'])->name('afficherDemandesAmitie');
    Route::post('/envoyer-demande-amitie/{utilisateur_recepteur_id}', [UserController::class, 'envoyerDemandeAmitie'])->name('envoyerDemandeAmitie');
    Route::get('/Search', [UserController::class, 'search'])->name('Search');

    Route::post('/accepter-demande/{id}', [AmisController::class, 'accepterDemandeAmitie'])->name('accepterDemandeAmitie');
    Route::delete('/refuser-demande/{id}', [AmisController::class, 'refuserDemandeAmitie'])->name('refuserDemandeAmitie');
    Route::delete('/annuler-demande/{id}', [AmisController::class, 'AnnulerDemandeAmitie'])->name('AnnulerDemandeAmitie');
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

// route pour message
    //Route::get('/auth/message', [MessageController::class, 'index'])->name('message.index'); // SUPPRIMER CETTE LIGNE
    Route::get('/invitation/{userId}/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');
    //Route::get('/chat', [MessageController::class, 'index'])->name('chat'); // SUPPRIMER CETTE LIGNE
    Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('send-message');
    Route::get('/chat/start/{userId}', [MessageController::class, 'startChatFromQr'])->name('chat.start.qr');
});

Route::group(['middleware' => ['auth:sanctum',config('jetstream.auth_session'), 'verified']], function () {
    Route::get('/chatify/{user}', [MessageController::class, 'index'])->name('chatify');

    // route pour message

    Route::get('/auth/message', [MessageController::class, 'index'])->name('message.index');
    Route::get('/invitation/{userId}/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');
    Route::get('/chat', [MessageController::class, 'index'])->name('chat');
    Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('send-message');



    Route::post('/messages/send', [CustomChatifyController::class, 'send'])->name('messages.send');

});


Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])
    ->name('social.redirect')
    ->middleware('guest');



Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])
    ->name('social.callback')
    ->middleware('guest');
// Routes pour connexion via Google ou Facebook grâce à Laravel Socialite.
Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');



// delete aut messaged 
Route::post('/toggle-auto-delete', [SettingController::class, 'toggleAutoDelete'])->name('toggleAutoDelete');

Route::get('/get-auto-delete-status', [SettingController::class, 'getAutoDeleteStatus'])->name('getAutoDeleteStatus');
