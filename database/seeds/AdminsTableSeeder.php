<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Admin::class)->state('admin')->create();
        factory(\App\Admin::class, 4)->create();
    }
}
