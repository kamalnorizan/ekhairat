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
        Schema::create('tblpenerima', function (Blueprint $table) {
            $table->id();
            $table->string('nokpketua', 14)->nullable();
            $table->string('nokpmeninggal', 14)->nullable();
            $table->string('kodpengguna', 20)->nullable();
            $table->string('tarikhmeninggal', 50);
            $table->string('hubungan', 50)->nullable();
            $table->string('kemaskini_oleh', 14);
            $table->string('manfaat', 20)->nullable();
            $table->string('tabung', 20)->nullable();
            $table->string('kubur', 100)->nullable();
            $table->string('ulasan', 255)->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('status', 2)->default('1');
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
        Schema::dropIfExists('tblpenerima');
    }
};
