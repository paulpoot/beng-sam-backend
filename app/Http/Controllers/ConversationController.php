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

        if($conversation) {
            if($conversation->updated_at > $request->header('If-Modified-Since')) {
                return response()->json($conversation->messages()->get())
                    ->header('Last-Modified', $conversation->updated_at);
            } else {
                return response()->json([], 304)->header('Last-Modified', $conversation->updated_at);
            }
        } else {
            return response()->json([], 404);
        }
    }
}
