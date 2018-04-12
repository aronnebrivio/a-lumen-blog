<?php

class UserTest extends TestCase
{
    public function testNewUser()
    {
        $email = 'test@example.com';
        $pwd = 'password';

        $this->post('/users', ['email' => $email, 'password' => $pwd])
            ->seeStatusCode(200);
    }

    public function testDuplicatedUser()
    {
        $email = 'test@example.com';
        $pwd = 'password';

        factory(App\User::class)->create([
            'email' => $email
        ]);
        $this->post('/users', ['email' => $email, 'password' => $pwd])
            ->seeStatusCode(409);
    }

    public function testAuth()
    {
        $user = factory(App\User::class)->create();

        $this->post('/')
            ->seeStatusCode(401);

        $this->post('/', [], ['Authentication' => $user->token])
            ->seeStatusCode(200);
    }

    public function testUserUpdate()
    {
        $user = factory(App\User::class)->create();
        $email = 'test@example.com';

        $this->put('/users', ['email' => $email])
            ->seeStatusCode(401);

        $this->actingAs($user);
        $this->put('/users', ['email' => $email])
            ->seeStatusCode(200);
    }

    public function testGetToken()
    {
        $password = 'password';
        $user = factory(App\User::class)->create([
            'password' => $password
        ]);
        $this->post('/login', ['email' => $user->email, 'password' => $password])
            ->seeStatusCode(200)
            ->seeJsonEquals(['token' => $user->token]);
    }
}
