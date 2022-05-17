<?php

use App\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'username' => 'admin',
        'full_name' => 'Mohammed BELIBEL',
        'admin' => 1,
        'lang' => 'ar',
        'password' => \Illuminate\Support\Facades\Hash::make('admin'), // secret
        'remember_token' => str_random(10),
    ];
});
