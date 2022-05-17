<?php

use Faker\Generator as Faker;

$factory->define(\App\Admin_permission::class, function (Faker $faker) {
    return [
        'statistics' => '11',
        'teachers' => '1111111',
        'students' => '11111111',
        'admins' => '1111',
        'countries' => '111',
        'home_work' => '111',
        'levels' => '111',
        'audios' => '111',
        'notifications' => '111',
        'groups' => '111',
        'settings' => '11111111',
        'admin_id' => 1,
    ];
});
