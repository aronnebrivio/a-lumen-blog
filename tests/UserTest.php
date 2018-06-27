<?php

use Illuminate\Support\Facades\Hash;

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
            ->seeStatusCode(422);
    }

    public function testUserUpdate()
    {
        $user = factory(App\User::class)->create();
        $email = 'test@example.com';

        $this->put('/users', ['email' => $email])
            ->seeStatusCode(401);

        /*
            UPDATE
            Al posto di usare actingAs() viene passato il token nell'header della richiesta.
            In questo modo è possibile testare il funzionamento del meccanismo di autorizzazione via token,
            senza dover creare un metodo ad-hoc.
        */
        $this->put('/users', ['email' => $email], ['Authorization' => $user->token])
            ->seeStatusCode(200);
    }

    public function testGetToken()
    {
        $password = 'password';
        $user = factory(App\User::class)->create([
            'password' => Hash::make($password)
        ]);
        $this->post('/auth', ['email' => $user->email, 'password' => $password])
            ->seeStatusCode(200)
            ->equalTo($user->token);

        $this->post('/auth', ['email' => $user->email, 'password' => 'wrong'])
            ->seeStatusCode(401);

        $this->post('/auth', ['email' => 'wrong@email.com', 'password' => 'wrong'])
            ->seeStatusCode(404);
    }

    public function testUserControllerCoverage()
    {
        $this->get('/users/' . 1)
            ->seeStatusCode(404);

        $user = factory(App\User::class)->create();

        $this->get('/users/' . 1)
            ->seeStatusCode(200)
            ->seeJsonEquals($user->toArray());

        $this->get('/users')
            ->seeStatusCode(200)
            ->seeJsonEquals([$user->toArray()]);
    }

    public function testUserCoverage()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
        $post = factory(App\Post::class)->create();
        $comment = factory(App\Comment::class)->create([
            'post_id' => $post->id
        ]);

        $this->assertEquals([$post->toArray()], $user->posts()->get()->toArray());
        $this->assertEquals([$comment->toArray()], $user->comments()->get()->toArray());
    }

    public function testUserNewValidation()
    {
        $this->post('/users')
            ->seeStatusCode(422);

        $this->post('/users', ['email' => 'test', 'password' => 'password'])
            ->seeStatusCode(422);

        $this->post('/users', ['email' => 'test@email.com'])
            ->seeStatusCode(422);

        $this->post('/users', ['email' => 'test@email.com', 'password' => 'password'])
            ->seeStatusCode(200);
    }

    public function testUserEditValidation()
    {
        factory(App\User::class)->create([
            'email' => 'test@email.com'
        ]);
        $user = factory(App\User::class)->create();

        $this->actingAs($user);
        $this->put('/users', ['email' => ''])
            ->seeStatusCode(422);

        $this->put('/users', ['email' => 'test'])
            ->seeStatusCode(422);

        $this->put('/users', ['email' => 'test@email.com'])
            ->seeStatusCode(422);

        $this->put('/users', ['email' => 'foo@bar.com'])
            ->seeStatusCode(200);
    }
}
