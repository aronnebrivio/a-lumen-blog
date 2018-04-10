<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
        /* insert */
        $user = new User;
        $user->fill($request->all());
        $user->save();
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        /* update */
        $user->fill($request->all());
        $user->save();
        return $user;
    }
}
