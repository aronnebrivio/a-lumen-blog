<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return User
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

        $user = new User();
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->token = Str::random(64);
        $user->save();

        return User::find($user->id);
    }

    /**
     * @param Request $request
     * @param mixed   $id
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return null|\Illuminate\Contracts\Auth\Authenticatable
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'filled|email|max:191',
            'first_name' => 'filled|string',
            'last_name' => 'filled|string',
            'password' => 'filled|string|min:6',
        ]);

        if ($this->emailExists($request->input('email'))) {
            return response('The email has already been taken.', 409);
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->id != $id) {
            return response('User not found', 404);
        }

        $user->fill($request->all());
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return $user;
    }

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
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

    private function emailExists($email)
    {
        return User::where('email', $email)
            ->where('id', '<>', Auth::user()->id)
            ->exists();
    }
}
