<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             AdminsTableSeeder::class,
             AdminPermissionsTableSeeder::class,
             LevelsTableSeeder::class,
             AppGuidesTableSeeder::class,
             CountriesTableSeeder::class,
             HomeWorksTableSeeder::class,
             UsersTableSeeder::class
         ]);
    }
}
