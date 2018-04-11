<?php

use Illuminate\Support\Facades\Hash;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($faker->text(10)),
        'token' => str_random(64)
    ];
});