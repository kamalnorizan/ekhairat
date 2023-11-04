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
        Schema::create('tblkeahlian', function (Blueprint $table) {
            $table->id();
            $table->string('name', 2);
            $table->string('statusahli', 2);
            $table->string('kodstatuspengguna', 5);
            $table->string('kodpengguna', 20);
            $table->string('nama', 255);
            $table->string('nokp', 14);
            $table->string('umur', 25);
            $table->string('tlahir', 25);
            $table->string('notel_r', 20)->nullable();
            $table->string('notel_hp', 20)->nullable();
            $table->string('notel_p', 20)->nullable();
            $table->string('alamat', 255);
            $table->bigInteger('ltalamat_id')->unsigned();
            $table->string('pekerjaan', 255);
            $table->string('status', 1);
            $table->string('namapasangan', 255);
            $table->string('nokppasangan', 14);
            $table->string('umurpasangan', 25);
            $table->string('tlahirpasangan', 25);
            $table->string('notelpasangan_hp', 25);
            $table->string('pekerjaanpasangan', 255);
            $table->string('namawaris', 255);
            $table->string('hubunganwaris', 255);
            $table->string('notelwaris_1', 255);
            $table->string('notelwaris_2', 255);
            $table->bigInteger('kelulusanoleh')->unsigned();
            $table->foreign('ltalamat_id')->references('id')->on('ltalamat')->onDelete('cascade');
            $table->foreign('kelulusanoleh')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tblkeahlian');
    }
};
