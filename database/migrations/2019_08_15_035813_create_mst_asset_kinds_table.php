<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstAssetKindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_asset_kinds', function (Blueprint $table) {
            $table->increments('kind_id');
            $table->unsignedInteger('kind_asset_group_id')->index();
            $table->string('kind_code', 45)->nullable();
            $table->string('kind_name');
            $table->text('kind_desc')->nullable();
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
        Schema::dropIfExists('mst_asset_kinds');
    }
}
