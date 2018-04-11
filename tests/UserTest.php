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
}
