<?php

use Faker\Generator as Faker;

$factory->define(\App\Home_work::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'level_id' => 1,
        'arranging_homework' => 1,
        'file_path' => '/home/u855202855/domains/manazel.tech/public_html/resources/homework_files/6d81f615f104b76b40626964ac2172ff.pdf',
        'file_url' => 'http://manazel.tech/resources/homework_files/6d81f615f104b76b40626964ac2172ff.pdf',
        'file_name' => '6d81f615f104b76b40626964ac2172ff.pdf',
        'tajweed_link' => 'https://www.facebook.com/watch/?v=373540039459377',
        'tafsir_link' => 'https://www.youtube.com/watch?v=2CDOsj9bn-M'
    ];
});
