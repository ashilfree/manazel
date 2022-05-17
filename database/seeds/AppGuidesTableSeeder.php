<?php

use Illuminate\Database\Seeder;

class AppGuidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\App_guide::class)->create();
    }
}
