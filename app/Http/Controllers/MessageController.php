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
        $user = $request->user();

        $conversation = Conversation::all()->where('user_id', $user['_id'])->first();

        if(!$conversation) {
            $conversation = Conversation::create([
                'user_id' => $user['_id'],
                'bot_id' => 'sam',
            ]);
        }

        if($conversation->id) {
            $message = Message::create([
                'content' => $request['content'],
                'user_id' => $user['_id'],
                'conversation_id' => $conversation->id,
            ]);

            $user->experience += strlen($message->content);
            $user->messagesSent++;
            $user->save();

            $conversation->touch();

            return response()->json($message);
        } else {
            return response()->json(['Conversation ID not set'], 500);            
        }        
    }

}
