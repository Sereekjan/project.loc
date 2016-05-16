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
            'name' => 'High'
        ]);
        DB::table('tasks_priorities')->insert([
            'name' => 'Medium'
        ]);
        DB::table('tasks_priorities')->insert([
            'name' => 'Low'
        ]);
    }
}
