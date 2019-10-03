<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_areas', function (Blueprint $table) {
            $table->increments('area_id');
            $table->string('area_code', 15);
            $table->unsignedInteger('area_region_id')->index();
            $table->unsignedInteger('area_ruas_id')->index();
            $table->string('area_name');
            $table->text('area_desc')->nullable();
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
        Schema::dropIfExists('mst_areas');
    }
}
