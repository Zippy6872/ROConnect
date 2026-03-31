<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;

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

        $message = $request->input('message');

        broadcast(new MessageSent($message))->toOthers();
        \Log::info('Bericht verzonden');

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
