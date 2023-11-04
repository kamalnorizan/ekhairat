<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smsblast_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('smsblast_group_id')->unsigned();
            $table->bigInteger('smsblast_id')->unsigned();
            $table->string('phoneNumber', 20);
            $table->string('status', 10)->default('pending');
            $table->string('referenceID', 100)->nullable();
            $table->foreign('smsblast_group_id')->references('id')->on('smsblast_groups');
            $table->foreign('smsblast_id')->references('id')->on('smsblasts');
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
        Schema::dropIfExists('smsblast_details');
    }
};
