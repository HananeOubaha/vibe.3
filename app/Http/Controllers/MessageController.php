<?php

namespace App\Http\Controllers;

use App\Models\messages;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendMessageJob;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use App\Models\ChMessage;

class MessageController extends Controller
{
    public function showcountnotif(){
        $notifCount = ChMessage::where('seen', 0);
        $test=$notifCount->count();
        return view('navigation-menu', compact('test'));
    }
    public function index(){
        $users = User::all();
        $notifications = auth()->user()->notifications;
        return view('messages', data: compact('users','notifications'));
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
                'conversation_id' => $request->conversation_id,
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
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

}
