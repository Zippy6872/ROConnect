<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Messages;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $messageText = $request->input('message');

        // $sessionId = session()->getId();
        $message = Messages::create([
            'room_id' => 1,
            'sender_id' => 1, 
            'original_text' => $messageText,
            'translated_text' => null,
            'target_language' => null,
        ]);

        broadcast(new MessageSent($messageText))->toOthers();
        \Log::info('Bericht verzonden',$message->toArray());

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
