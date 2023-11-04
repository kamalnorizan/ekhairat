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
        Schema::create('smsblast_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('smsblast_id')->unsigned();
            $table->string('customRreferenceId', 255)->nullable();
            $table->string('status', 10)->default('pending');
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
        Schema::dropIfExists('smsblast_groups');
    }
};
