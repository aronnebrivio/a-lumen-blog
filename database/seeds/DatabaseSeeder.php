<?php

use App\Comment;
use App\Post;
use App\User;
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
            'email' => 'aroblu94@gmail.com',
            'token' => 'a0h1WP0vmDEFeRTdefc7b9VLjpIiovbcwibrlnpdqmqxpZR5fR2kwnFCeJeGHsa3',
            'password' => Hash::make('password'),
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
