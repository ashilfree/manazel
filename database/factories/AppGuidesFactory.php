<?php

use Faker\Generator as Faker;

$factory->define(\App\App_guide::class, function (Faker $faker) {
    return [
        'title' => '⭐ منازل الأبرار لتثبيت وحفظ القرآن ⭐',
        'en_title' => 'Manazel Al Abrar',
        'description' => 'طريقة منهجية متينة لحفظ وتثبيت القرآن الكريم تعتمد على حفظ يومي جديد وتثبيت المحفوظ القديم من خلال برنامج أسبوعي يرسل عبر المجموعات للمشاركات، ويتم من خلال التطبيق متابعة الأداء اليومي والتزامهم',
        'en_description' => 'A methodology to memorize the Holy Qur’an based on daily memorization and the memorization, and a weekly program will be sent to the groups through the application. The daily performance and the students commitment are monitored in the application',
        'image' => '/home/u855202855/domains/manazel.tech/public_html/resources/images/fb48700e9ac777842533a8f84ad95d2f.jpeg'
    ];
});
