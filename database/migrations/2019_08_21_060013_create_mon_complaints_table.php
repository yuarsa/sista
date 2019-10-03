<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mon_complaints', function (Blueprint $table) {
            $table->bigIncrements('complain_id');
            $table->string('complain_code', 45);
            $table->string('complain_failure');
            $table->string('complain_name');
            $table->text('complain_address');
            $table->text('complain_desc')->nullable();
            $table->boolean('complain_status')->default(1);
            $table->string('complain_image')->nullable();
            $table->string('complain_image1')->nullable();
            $table->string('complain_image2')->nullable();
            $table->string('complain_image3')->nullable();
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
        Schema::dropIfExists('mon_complaints');
    }
}
