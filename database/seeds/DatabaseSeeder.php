<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create users
        $users[] = factory(User::class)->create([
            'email' => 'testblog.aronnebrivio@dispostable.com',
            'first_name' => 'Foo',
            'last_name' => 'Bar',
        ]);
        for ($i = 0; $i < 4; $i++)
            $users[] = factory(User::class)->create();

        // Create posts
        $posts = [];
        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $posts[] = factory(Post::class)->create([
                    'user_id' => $user->id,
                ]);
            }
        }

        // Create comments
        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                $post = $posts[array_rand($posts)];
                factory(Comment::class)->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
