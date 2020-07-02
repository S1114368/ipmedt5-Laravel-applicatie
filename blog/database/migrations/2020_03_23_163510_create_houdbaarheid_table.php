<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoudbaarheidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houdbaarheid', function (Blueprint $table) {
            $table->increments('id')->primarykey();
            $table->integer('item_id')->foreignkey();
            $table->date('houdbaarheidsdatum')->nullable();
            $table->integer('aantal_dagen_houdbaar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houdbaarheid');
    }
}
