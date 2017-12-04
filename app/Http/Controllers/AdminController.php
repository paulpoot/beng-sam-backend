<?php

namespace App\Http\Controllers;

use App\Message;
use App\Conversation;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show() {
        return view('admin');
    }

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

    public function conversationIndex() {
        $conversations = Conversation::all();
        $users = User::all();

        foreach($conversations as $conversation) {
            $user = $users->find($conversation->user_id);
            $conversation->name = $user->name;
            $conversation->email = $user->email;
        }

        return response()->json($conversations);
    }

    public function conversationShow($id) {
        $conversation = Conversation::find($id);
        $conversation->messages = $conversation->messages()->get();

        return response()->json($conversation);
    }

    public function conversationDelete($id) {
        $conversation = Conversation::find($id);
        $messages = $conversation->messages()->delete();
        $conversation = $conversation->delete();
        
        return response()->json();
    }

    public function reply(Request $request) {
        $this->validate($request, [
            'content'     => 'required',
            'conversation_id' => 'required',
            'type' => 'required',
        ]);

        return Message::create([
            'content' => $request['content'],
            'user_id' => $request->user()['_id'],
            'conversation_id' => $request['conversation_id'],
            'type' => $request['type'],
        ]);
    }
}
