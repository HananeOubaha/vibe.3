<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendMessageJob;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;
class MessageController extends Controller
{
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

        event(new MessageSent($user, $message, $receiverId));

        dispatch(new SendMessageJob($user, $receiverId, $message));

        return response()->json(['status' => 'Message envoyé !']);
    }

}
