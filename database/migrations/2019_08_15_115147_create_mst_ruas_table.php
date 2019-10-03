<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstRuasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_ruas', function (Blueprint $table) {
            $table->increments('ruas_id');
            $table->unsignedInteger('ruas_region_id')->index();
            $table->string('ruas_code', 45);
            $table->string('ruas_name');
            $table->text('ruas_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_ruas');
    }
}
