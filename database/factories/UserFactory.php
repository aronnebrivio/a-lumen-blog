<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('password'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
    ];
});
