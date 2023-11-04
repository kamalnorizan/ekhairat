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
        Schema::create('tbltanggungan', function (Blueprint $table) {
            $table->id();
            $table->string('kodpengguna', 25)->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('nokp', 14)->nullable();
            $table->string('umur', 25)->nullable();
            $table->string('tlahir', 25)->nullable();
            $table->string('nokpketua', 14);
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
        Schema::dropIfExists('tbltanggungan');
    }
};
