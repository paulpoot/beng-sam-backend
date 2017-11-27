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
}
