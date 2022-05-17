<?php

use Faker\Generator as Faker;

$factory->define(\App\Country::class, function (Faker $faker) {
    return [
        'name' => $faker->country,
        'en_name' => $faker->country,
        'country_code' => $faker->countryCode,
        'phone_code' => '+213'
    ];
});
