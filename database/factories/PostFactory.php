<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->text(50),
        'text' => $faker->text(300),
    ];
});