<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $type = $faker->randomElement(['student', 'teacher']);
    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'birthday' => $faker->date(),
        'quran_parts' => $faker->numberBetween(0, 30),
        'spare_time' => '',
        'type' => $faker->randomElement(['student', 'teacher']),
        'level_id' => $faker->numberBetween(1, 4),
        'email_verified_at' => now(),
        'password' => \Illuminate\Support\Facades\Hash::make($type), // secret
        'remember_token' => str_random(10),
        'image' => '',
        'lang' => $faker->randomElement(['ar', 'en']),
        'mogazh' => $faker->numberBetween(0, 1),
        'mastery_certificates' => $faker->numberBetween(0, 5),
        'push_token' => '',
    ];
});
