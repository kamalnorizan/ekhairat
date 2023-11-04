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
        Schema::create('tblbayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kodpengguna', 20);
            $table->string('nokp', 14);
            $table->string('nobil', 50);
            $table->string('statusbayaran', 2)->default(0);
            $table->bigInteger('kelulusanbayaran_oleh')->unsigned()->nullable();
            $table->string('kelulusanbayaran_pada', 50)->nullable();
            $table->string('jumlahbayaran', 250);
            $table->string('buktibayaran', 250)->nullable();
            $table->string('carabayaran', 20);
            $table->string('refnumber', 20);
            $table->string('jenisbank', 50);
            $table->string('noresit', 50)->nullable();
            $table->foreign('kelulusanbayaran_oleh')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tblbayaran');
    }
};
