<?php

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->text(50),
        'text' => $faker->text(300),
        'user_id' => null
    ];
});