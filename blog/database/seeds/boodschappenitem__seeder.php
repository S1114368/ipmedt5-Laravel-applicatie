<?php

use Illuminate\Database\Seeder;

class boodschappenitem__seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('boodschappenitem')->insert([
        'user_id' => 1,
        'item_id' => 6,
        'aantal' => 4,
        'gewicht' => 100,
        'naam' => 'Unox Worst Knaks'
      ]);
      DB::table('boodschappenitem')->insert([
        'user_id' => 1,
        'item_id' => 2,
        'aantal' => 4,
        'gewicht' => 100,
        'naam' => 'Rijst'
      ]);
      DB::table('boodschappenitem')->insert([
        'user_id' => 1,
        'item_id' => 3,
        'aantal' => 4,
        'gewicht' => 100,
        'naam' => 'Water'
      ]);
    }
}
