<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function get($id)
    {
        return User::findOrFail($id);
    }

    public function getAll()
    {
        return User::all();
    }

    /**
     * @param Request $request
     * @return User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function new(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:191',
            'password' => 'required|string|min:6',
        ]);
        $data = $request->all();
        $user = new User;
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->token = str_random(64);
        $user->save();
        return $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:191',
        ]);
        $user = Auth::user();
        $user->fill($request->all());
        $user->save();
        return $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getToken(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $data = $request->all();
        $user = User::where('email', $data['email'])
            ->first();
        if ($user) {
            if (Hash::check($data['password'], $user->password))
                return $user->token;
            return response('Wrong password', 401);
        }

        return response('User not found', 404);
    }
}
