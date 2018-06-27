<?php

use Illuminate\Support\Facades\Hash;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('password'),
        'token' => str_random(64)
    ];
});