<?php

use App\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Group::class, 10)->create();
        $students = \App\User::where('type', 'student')->get();
        foreach ($students as $student){
            $groups = Group::where('level_id', $student->level_id)->get();

            $student->group_id = $groups->random()->id ?? 1;
            $student->save();
        }
    }
}
