<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstMatriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_matriks', function (Blueprint $table) {
            $table->increments('matrik_id');
            $table->unsignedBigInteger('matrik_asset_id')->index();
            $table->string('matrik_name');
            $table->text('matrik_desc')->nullable();
            $table->unsignedTinyInteger('matrik_fault_id')->index();
            $table->unsignedTinyInteger('matrik_repair_id')->index();
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
        Schema::dropIfExists('mst_matriks');
    }
}
