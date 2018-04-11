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
        return User::find($id);
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
        $logged = Auth::user();
        $user = User::find($logged->id);
        $user->fill($request->all());
        $user->save();
        return $user;
    }
}
