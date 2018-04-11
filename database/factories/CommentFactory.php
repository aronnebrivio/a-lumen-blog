<?php

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'text' => $faker->text(300),
        'user_id' => null,
        'post_id' => null
    ];
});