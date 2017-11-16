<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function createMessage(Request $request) {
        $message = Message::create($request->all());

        return response()->json($message);
    }

}
