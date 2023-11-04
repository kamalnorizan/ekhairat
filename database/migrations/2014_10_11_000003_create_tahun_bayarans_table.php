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
        Schema::create('lttahun_bayaran', function (Blueprint $table) {
            $table->id();
            $table->string('tahunbayaran', 4);
            $table->string('tahun1', 4);
            $table->string('tahun2', 4);
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
        Schema::dropIfExists('lttahun_bayaran');
    }
};
