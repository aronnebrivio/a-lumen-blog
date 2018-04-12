<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get($id)
    {
        return User::findOrFail($id);
    }

    public function getAll()
    {
        return User::all();
    }

    public function new(Request $request)
    {
        $data = $request->all();
        if (User::where('email', $data['email'])->first())
            return response('Invalid email', 409);

        $user = new User;
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->token = str_random(64);
        $user->save();
        return $user;
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->fill($request->all());
        $user->save();
        return $user;
    }

    public function getToken(Request $request)
    {
        $data = $request->all();
        $user = User::where('email', $data['email'])
            ->first();
        if($user) {
            if(Hash::check($data['password'], $user->password))
                return $user->token;
            return response('Wrong password', 401);
        }

        return response('User not found', 404);
    }
}
