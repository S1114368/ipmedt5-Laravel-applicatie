<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test')->insert([
        'username' => 'test',
        'password' => 'testtest',
      ]);
        DB::table('test')->insert([
        'username' => 'test123',
        'password' => 'testtest123',
      ]);
    }
}
