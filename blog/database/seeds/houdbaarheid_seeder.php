<?php

use Illuminate\Database\Seeder;
class houdbaarheid_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('houdbaarheid')->insert([
          'item_id' => 1,
          'houdbaarheidsdatum' => "2020-04-03",
          'aantal_dagen_houdbaar' => 20
        ]);
        DB::table('houdbaarheid')->insert([
          'item_id' => 2,
          'houdbaarheidsdatum' => "2020-05-02",
          'aantal_dagen_houdbaar' => 20
        ]);
        DB::table('houdbaarheid')->insert([
          'item_id' => 3,
          'houdbaarheidsdatum' => "2020-06-01",
          'aantal_dagen_houdbaar' => 20
        ]);
        DB::table('houdbaarheid')->insert([
          'item_id' => 4,
          'houdbaarheidsdatum' => "2020-07-01",
          'aantal_dagen_houdbaar' => 20
        ]);
        DB::table('houdbaarheid')->insert([
          'item_id' => 5,
          'houdbaarheidsdatum' => "2020-07-01",
          'aantal_dagen_houdbaar' => 20
        ]);
    }
}
