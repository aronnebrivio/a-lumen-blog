<?php

class ExceptionTest extends TestCase
{
    public function testMethodNotAllowedEx()
    {
        $user = factory(App\User::class)->create();
        $response = $this->call('POST','/users/' . $user->id);

        $this->assertEquals(405, $response->status());
        $this->assertEquals('Method Not Allowed.', $response->content());
    }

    public function testErrorEx()
    {
        $user = factory(App\User::class)->create();
        $response = $this->call('POST','/auth/', ['email' => $user->email]);

        $this->assertEquals(422, $response->status());
        $this->assertEquals('Unprocessable. Please provide all inputs and retry.', $response->content());
    }
}