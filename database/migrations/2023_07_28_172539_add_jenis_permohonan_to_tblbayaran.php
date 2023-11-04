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
        Schema::table('tblbayaran', function (Blueprint $table) {
            $table->integer('jenisPermohonan')->unsigned()->default(1)->comment('1 = Pembaharuan, 2 = Mohon Baru')->after('nobil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblbayaran', function (Blueprint $table) {
            $table->dropColumn('jenisPermohonan');
        });
    }
};
