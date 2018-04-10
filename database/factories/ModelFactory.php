<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => 'password'
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'text' => str_random(300),
        'user_id' => ''
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'text' => str_random(300),
        'user_id' => '',
        'post_id' => ''
    ];
});
