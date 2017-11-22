<?php

namespace App\Http\Controllers;

use App\Message;
use App\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index() {
        $messages = Message::all();

        return response()->json($messages);
    }

    public function createMessage(Request $request) {
        $user = $request->user()['_id'];

        $conversation_id = null;
        $conversation = Conversation::all()->where('user_id', $user)->first();

        if($conversation) {
            $conversation_id = $conversation->id;
        }
        
        if(!$conversation_id) {
            $conversation_id = Conversation::create([
                'user_id' => $user,
                'bot_id' => 'sam',
            ])->id;
        }

        if($conversation_id) {
            $message = Message::create([
                'content' => $request['content'],
                'user_id' => $request->user()['_id'],
                'conversation_id' => $conversation_id,
            ]);

            return response()->json($message);
        } else {
            return response()->json(['Conversation ID not set'], 500);            
        }        
    }

}
