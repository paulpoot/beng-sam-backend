<?php

namespace App\Http\Controllers;

use App\Message;
use App\Conversation;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $users = User::all();
        $conversations = Conversation::all();
        $messages = Message::all();

        return response()->json(array(
            'users' => $users,
            'conversations' => $conversations,
            'messages' => $messages
        ));
    }

    public function reply(Request $request) {
        $this->validate($request, [
            'content'     => 'required',
            'conversation_id' => 'required',
        ]);

        return Message::create([
            'content' => $request['content'],
            'user_id' => $request->user()['_id'],
            'conversation_id' => $request['conversation_id'],
        ]);
    }
}
