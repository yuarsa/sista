<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToMonAssetPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mon_asset_performances', function (Blueprint $table) {
            $table->string('assetperf_name')->nullable()->after('assetperf_code');
            $table->tinyInteger('assetperf_shift')->nullable()->after('assetperf_percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mon_asset_performances', function (Blueprint $table) {
            $table->dropColumn('assetperf_name');
            $table->dropColumn('assetperf_shift');
        });
    }
}
