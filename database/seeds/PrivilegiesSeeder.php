<?php

use Illuminate\Database\Seeder;

class PrivilegiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privilegies')->insert([
            'name' => 'editor'
        ]);
        DB::table('privilegies')->insert([
            'name' => 'listener'
        ]);
    }
}
