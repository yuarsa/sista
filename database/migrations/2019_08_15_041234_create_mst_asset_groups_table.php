<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstAssetGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_asset_groups', function (Blueprint $table) {
            $table->increments('assetgrp_id');
            $table->string('assetgrp_code', 45)->nullable();
            $table->string('assetgrp_name');
            $table->text('asssetgrp_desc')->nullable();
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
        Schema::dropIfExists('mst_asset_groups');
    }
}
