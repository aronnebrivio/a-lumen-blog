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

        $this->post('/', [], ['Authorization', $user->token])
            ->seeStatusCode(200);
    }
}
