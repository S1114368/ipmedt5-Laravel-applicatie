<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('user_id')->foreignkey()->nullable();
            $table->integer('houdbaarheid_id')->foreignkey()->nullable();
            $table->string('naam');
            $table->bigInteger('barcode');
            $table->integer('gewicht_nieuw')->nullable();
            $table->integer('gewicht_huidig')->nullable();
            $table->integer('plank_positie')->nullable();
            $table->string('image_url');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
