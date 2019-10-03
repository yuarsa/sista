<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonAssetPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mon_asset_performances', function (Blueprint $table) {
            $table->bigIncrements('assetperf_id');
            $table->unsignedInteger('assetperf_asset_group_id')->index();
            $table->unsignedBigInteger('assetperf_asset_id')->index();
            $table->string('assetperf_code', 45);
            $table->boolean('assetperf_is_work');
            $table->text('assetperf_desc')->nullable();
            $table->double('assetperf_percentage', 20, 2)->nullable();
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
        Schema::dropIfExists('mon_asset_performances');
    }
}
