<?php

use Illuminate\Database\Seeder;

class HomeWorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Home_work::class)->create();
    }
}
