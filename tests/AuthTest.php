<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * @internal
 */
class AuthTest extends TestCase
{
    public function testLogin()
    {
        $password = 'password';
        $user = factory(User::class)->create([
            'password' => Hash::make($password),
        ]);

        $this->post('auth/login', ['email' => $user->email, 'password' => $password])
            ->seeStatusCode(200)
            ->seeJson(['token_type' => 'bearer'])
            ->seeJsonStructure(['expires_in', 'access_token', 'expires_in', 'token_type']);

        $this->post('auth/login', ['email' => $user->email, 'password' => 'wrong'])
            ->seeStatusCode(401);

        $this->post('auth/login', ['email' => 'wrong@email.com', 'password' => $password])
            ->seeStatusCode(401);
    }
}
