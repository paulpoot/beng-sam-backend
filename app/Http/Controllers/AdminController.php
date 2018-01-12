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

    public function conversationShow(Request $request, $id) {
        $conversation = Conversation::findOrFail($id);
        $conversation->messages = $conversation->messages()->get();

        if($conversation->updated_at > $request->header('If-Modified-Since')) {
            return response()->json($conversation)
                ->header('Last-Modified', $conversation->updated_at);
        } else {
            return response()->json([], 304)->header('Last-Modified', $conversation->updated_at);
        }
    }

    public function conversationDelete($id) {
        $conversation = Conversation::find($id);
        $messages = $conversation->messages()->delete();
        $conversation = $conversation->delete();
        
        return response()->json();
    }

    public function messageSend(Request $request) {
        $this->validate($request, [
            'content'     => 'required',
            'conversation_id' => 'required',
            'type' => 'required',
        ]);

        if(Message::create([
            'content' => $request['content'],
            'user_id' => $request->user()['_id'],
            'conversation_id' => $request['conversation_id'],
            'type' => $request['type'],
        ])) {
            $conversation = Conversation::find($request['conversation_id']);
            $conversation->touch();
    
            $user = User::find($conversation->user_id);
            $user->messagesReceived++;
            $user->save();
        };

        return response()->json();
    }

    public function messageDelete($id) {
        $message = Message::find($id);
        $message->delete();
        
        return response()->json();
    }
}
