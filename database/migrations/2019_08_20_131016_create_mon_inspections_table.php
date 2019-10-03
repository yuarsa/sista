<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mon_inspections', function (Blueprint $table) {
            $table->bigIncrements('insp_id');
            $table->string('insp_code', 45);
            $table->unsignedInteger('insp_area_id')->index();
            $table->unsignedInteger('insp_asset_group_id')->index();
            $table->unsignedBigInteger('insp_asset_id')->index();
            $table->string('insp_volume')->nullable();
            $table->unsignedInteger('insp_matrik_id')->index();
            $table->text('insp_desc')->nullable();
            $table->text('insp_follow_up')->nullable();
            $table->boolean('insp_status')->default(1);
            $table->string('insp_image')->nullable();
            $table->string('insp_image1')->nullable();
            $table->string('insp_image2')->nullable();
            $table->string('insp_image3')->nullable();
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
        Schema::dropIfExists('mon_inspections');
    }
}
