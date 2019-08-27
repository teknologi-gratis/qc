<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelurahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->string('id_kel');
            $table->string('id_kec');
            $table->foreign('id_kec')->references('id_kec')->on('kecamatan')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('nama');
            $table->integer('id_jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelurahan');
    }
}
