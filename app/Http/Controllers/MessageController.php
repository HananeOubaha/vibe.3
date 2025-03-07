<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendMessageJob;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Chatify\Facades\Chatify;
use App\Models\messages;
use Illuminate\Support\Str;

class MessageController extends Controller
{

    public function index()
    {
        $users = User::all();
        $notifications = auth()->user()->notifications;
        return view('messages', data: compact('users', 'notifications'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);
        $user = auth()->user();
        $message = $request->message;
        $receiverId = $request->receiver_id;

        try {
            $message = messages::create([
                'conversation_id' => Str::uuid(),
                'sender_id' => $user->id,
                'receiver_id' => $receiverId,
                'message' => $request->message,
            ]);

            event(new MessageSent($user, $message, $receiverId));

            dispatch(new SendMessageJob($user, $receiverId, $message));
            return response()->json(['success' => true, 'message' => 'Message sent']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }

    public function startChatFromQr(Request $request, $userId)
    {
        $currentUser = Auth::user();
        $recipient = User::findOrFail($userId);

        // Redirige vers la route Chatify
        return Redirect::to('/chatify/'.$userId);
    }

    // Helper function pour vérifier si une conversation existe déjà
    private function getExistingConversation($userId1, $userId2)
    {
          return messages::where(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId1)
                  ->where('receiver_id', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('sender_id', $userId2)
                  ->where('receiver_id', $userId1);
        })->first();
    }

    // Helper function pour créer une nouvelle conversation
    private function createNewConversation($userId1, $userId2)
    {
          $message = messages::create([
            'conversation_id' => Str::uuid(),
            'sender_id' => $userId1,
            'receiver_id' => $userId2,
            'message' => "Salut! Nouvelle conversation initiée via QR code.", // Message initial
        ]);

        return (object) ['id' => $message->conversation_id];
    }

}
