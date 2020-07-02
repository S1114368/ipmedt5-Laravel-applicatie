<?php

use Illuminate\Database\Seeder;

class items_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
          'user_id' => 12,
          'houdbaarheid_id' => 1,
          'naam' => 'Unox Worst Knaks',
          'barcode' => 8712100806087,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 1,
          'image_url' => 'css/img/knaks.jpg'
        ]);
        DB::table('items')->insert([
          'user_id' => 12,
          'houdbaarheid_id' => 2,
          'naam' => 'Rijst',
          'barcode' => 871210080608,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 2,
          'image_url' => 'css/img/rijst.jpg'
        ]);
        DB::table('items')->insert([
          'user_id' => 11,
          'houdbaarheid_id' => 3,
          'naam' => 'Appel',
          'barcode' => 87121080687,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 3,
          'image_url' => 'css/img/Ketoembar|_Conimex.png'
        ]);
        DB::table('items')->insert([
          'user_id' => 11,
          'houdbaarheid_id' => 4,
          'naam' => 'Rijst',
          'barcode' => 8712008060875,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 2,
          'image_url' => 'css/img/rijst.jpg'
        ]);
        DB::table('items')->insert([
          'user_id' => 13,
          'houdbaarheid_id' => 5,
          'naam' => 'Water',
          'barcode' => 8712100380687,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 3,
          'image_url' => 'css/img/rijst.jpg'
        ]);
        DB::table('items')->insert([
          'user_id' => 11,
          'houdbaarheid_id' => 1,
          'naam' => 'Soep',
          'barcode' => 87200806087,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 2,
          'image_url' => 'css/img/rijst.jpg'
        ]);
        DB::table('items')->insert([
          'user_id' => 11,
          'houdbaarheid_id' => 1,
          'naam' => 'Soep',
          'barcode' => 71200806087,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 2,
          'image_url' => 'css/img/rijst.jpg'
        ]);
        DB::table('items')->insert([
          'user_id' => 11,
          'houdbaarheid_id' => 1,
          'naam' => 'Soep2',
          'barcode' => 71200806087,
          'gewicht_nieuw' => 400,
          'gewicht_huidig' => 400,
          'plank_positie' => 2,
          'image_url' => 'css/img/rijst.jpg'
        ]);
    }
}
