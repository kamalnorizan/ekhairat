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
        Schema::create('tblbayaran_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bayaran_id')->unsigned();
            $table->string('noBil', 50);
            $table->float('amaun', 8, 2);
            $table->string('jenis', 100)->default('yuran');
            $table->string('tahun', 4);
            $table->foreign('bayaran_id')->references('id')->on('tblbayaran')->onDelete('cascade');
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
        Schema::dropIfExists('tblbayaran_details');
    }
};
