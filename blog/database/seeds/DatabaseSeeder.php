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
        $this->call(items_seeder::class);
        $this->call(boodschappenitem__seeder::class);
        $this->call(houdbaarheid_seeder::class);
        //$this->call(RolesTableSeeder::class);
    }
}
