<?php

use Illuminate\Database\Seeder;

class TaskPrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks_priorities')->insert([
            'name' => 'high'
        ]);
        DB::table('tasks_priorities')->insert([
            'name' => 'medium'
        ]);
        DB::table('tasks_priorities')->insert([
            'name' => 'low'
        ]);
    }
}
