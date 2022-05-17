<?php

use Faker\Generator as Faker;

$factory->define(\App\Level::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'en_name' => $faker->name,
        'level' => $faker->word,
        'en_level' => $faker->word
    ];
});
