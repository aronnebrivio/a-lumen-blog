<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    /**
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return User
     */
    public function get($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     *
     * @psalm-return \Illuminate\Database\Eloquent\Collection|array<array-key, User>
     */
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
            'picture' => 'filled|url',
        ]);

        $data = $request->all();

        $user = new User();
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        return User::find($user->id);
    }

    /**
     * @param Request $request
     * @param mixed   $id
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|User
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'filled|email|max:191',
            'first_name' => 'filled|string',
            'last_name' => 'filled|string',
            'password' => 'filled|string|min:6',
            'picture' => 'filled|url',
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
            Auth::logout();
        }
        $user->save();

        return $user;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    private function emailExists($email)
    {
        return User::where('email', $email)
            ->where('id', '<>', Auth::user()->id)
            ->exists();
    }
}
