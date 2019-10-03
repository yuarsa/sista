<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_assets', function (Blueprint $table) {
            $table->bigIncrements('asset_id');
            $table->string('asset_type', 5);
            $table->unsignedInteger('asset_region_id')->index();
            $table->unsignedInteger('asset_area_id')->index();
            $table->unsignedInteger('asset_point_id')->index();
            $table->string('asset_code', 45);
            $table->unsignedInteger('asset_asset_group_id')->index();
            $table->string('asset_name');
            $table->string('asset_year', 5);
            $table->text('asset_desc')->nullable();
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
        Schema::dropIfExists('mst_assets');
    }
}
