<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoodschappenitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boodschappenitem', function (Blueprint $table) {
            $table->integer('user_id')->foreignkey();
            $table->integer('item_id')->nullable();
            $table->integer('aantal');
            $table->integer('gewicht')->nullable();
            $table->string('naam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boodschappenitem');
    }
}
