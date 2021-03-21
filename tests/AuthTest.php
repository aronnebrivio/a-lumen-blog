<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @internal
 */
class AuthTest extends TestCase
{
    public function testLogin()
    {
        $password = 'password';
        $user = User::factory()->create([
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

    public function testLogout()
    {
        $this->refreshApplication();

        $user = User::factory()->create();
        // NOTE: in order to make logout() function working we have to pass the JWT token -> can't use standard actingAs function
        $token = JWTAuth::fromUser($user);

        $this->post('auth/logout', [], ['Authorization' => 'Bearer ' . $token])
            ->seeStatusCode(200)
            ->seeJson(['message' => 'Successfully logged out']);
    }

    public function testRefresh()
    {
        $this->refreshApplication();

        $user = User::factory()->create();
        // NOTE: in order to make logout() function working we have to pass the JWT token -> can't use standard actingAs function
        $token = JWTAuth::fromUser($user);

        $this->json('POST', 'auth/refresh', [], ['Authorization' => 'Bearer ' . $token])
            ->seeStatusCode(200)
            ->seeJson(['token_type' => 'bearer']);
    }

    public function testMe()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('auth/me')
            ->seeStatusCode(200)
            ->seeJson(['id' => $user->id, 'email' => $user->email]);
    }
}
