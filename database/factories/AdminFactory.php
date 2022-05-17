<?php

use App\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'full_name' => $faker->name,
        'admin' => 1,
        'lang' => $faker->randomElement(['ar', 'en']),
        'password' => \Illuminate\Support\Facades\Hash::make('admin'), // secret
        'remember_token' => str_random(10),
    ];
});

$factory->state(Admin::class, 'admin', function (Faker $faker){
    return [
        'username' => 'admin',
        'full_name' => 'Mohammed BELIBEL',
    ];
});

