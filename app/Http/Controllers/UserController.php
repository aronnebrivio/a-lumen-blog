<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function test(Request $request)
    {
        if($request->filled("password", "email")) {
            $input = $request->all();

            /* insert */
            $user = new User;
            $user->email = rand(1,300);
            $user->password = $input["password"];
            $user->save();

            /* update */
            $user = User::find(1);
            $user->fill(["email" => $input["email"], "password" => "lalala"]);
            //$user->created_at = date('Y-m-d H:i:s');
            $user->save();
        }

        return User::all();
    }

    public function test2(Request $request, $id)
    {
        $user = User::find($id);

        if($request->filled("password", "email")) {
            $input = $request->all();

            /* update */
            $user->fill(["email" => $input["email"], "password" => $input["password"]]);
            $user->save();
        }

        return $user;
    }
}
