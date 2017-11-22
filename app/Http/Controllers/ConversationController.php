<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function loadMessages(Request $request) {
        $user = $request->user();

        $conversation = Conversation::all()->where('user_id', $user['_id'])->first();

        return response()->json($conversation->messages()->get());
    }

    public function createMessage(Request $request) {
        $message = Message::create([
            'content' => $request['content'],
            'user_id' => $request->user()['_id'],
            'conversation_id' => '0',
        ]);

        return response()->json($message);
    }

}
