<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Str;

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
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'first_name' => 'filled|string',
            'last_name' => 'filled|string',
        ]);

        $data = $request->all();

        $user = new User;
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->token = Str::random(64);
        $user->save();

        $user = User::find($user->id);
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
            'email' => 'filled|email|max:191',
            'first_name' => 'filled|string',
            'last_name' => 'filled|string',
            'password' => 'filled|string|min:6',
        ]);

        if (!$this->checkEmail($request->input('email'))) {
            return response('The email has already been taken.', 409);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->fill($request->all());
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return $user;
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getToken(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $data = $request->all();

        $user = User::where('email', $data['email'])->first();

        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                return ['id' => $user->id, 'token' => $user->token];
            }
            return response('Wrong password', 401);
        }

        return response('User not found', 404);
    }

    private function checkEmail($email)
    {
        $nusers = User::where('email', $email)
            ->where('id', '<>', Auth::user()->id)
            ->count();

        if ($nusers > 0) {
            return false;
        }
        return true;
    }
}
