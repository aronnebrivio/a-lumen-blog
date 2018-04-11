<?php

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'text' => $faker->text(300),
        'user_id' => null
    ];
});