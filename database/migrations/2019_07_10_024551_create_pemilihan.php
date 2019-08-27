<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemilihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemilihan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('jenis');
            $table->integer('tahun');
            $table->integer('prov_id');
            $table->foreign('prov_id')->references('id_prov')->on('provinsi')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('kab_id');
            $table->foreign('kab_id')->references('id_kab')->on('kabupaten')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists('pemilihan');
    }
}
