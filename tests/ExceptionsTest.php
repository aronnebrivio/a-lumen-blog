<?php

use App\Models\User;

/**
 * @internal
 */
class ExceptionsTest extends TestCase
{
    public function testMethodNotAllowedEx()
    {
        $user = factory(User::class)->create();
        $response = $this->call('POST', 'users/' . $user->id);

        $this->assertEquals(405, $response->status());
        $this->assertEquals('Method Not Allowed.', $response->content());
    }

    public function testErrorEx()
    {
        $user = factory(User::class)->create();
        $response = $this->call('POST', 'auth/login', ['email' => $user->email]);

        $this->assertEquals(422, $response->status());
        $this->assertEquals('{"password":["The password field is required."]}', $response->content());
    }
}
