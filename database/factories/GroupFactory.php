<?php

use App\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    $teachers = \App\User::where('type' , 'teacher')->get();
    return [
        'name' => $faker->name,
        'en_name' => $faker->name,
        'max_students' => $faker->numberBetween(30, 50),
        'level_id' => $faker->numberBetween(1, 4),
        'teacher_id' => $faker->randomElement($teachers)->id,
        'main_supervisor_id' => 1,
        'assistant_supervisor_id' => 1
    ];
});



