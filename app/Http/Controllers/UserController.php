<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function show(Request $request) {
        $user = $request->user();

        return response()->json($user);
    }

    public function update(Request $request) {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required|max:16',
            'age' => 'required|numeric',
            'email' => 'required|email|max:255|unique:users,email,'.$user->_id.',_id',
            'password' => 'required',
        ]);

        if(app('hash')->check($request['password'], $user->password)) {
            $user->name = $request->name;
            $user->age = $request->age;
            $user->email = $request->email;
    
            if($request->input('new_password')) {
                $user->password = app('hash')->make($request['new_password']);
            }
    
            if($user->save()) {
                return response()->json([], 200);
            } else {
                return response()->json([], 500);
            }
        } else {
            return response()->json([], 401);
        }
    }
}
