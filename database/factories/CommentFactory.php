<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'text' => $faker->text(300),
    ];
});