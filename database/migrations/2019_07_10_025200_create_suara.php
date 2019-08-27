<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suara', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prov_id');
            $table->foreign('prov_id')->references('id_prov')->on('provinsi')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('kab_id');
            $table->foreign('kab_id')->references('id_kab')->on('kabupaten')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('kec_id');
            $table->foreign('kec_id')->references('id_kec')->on('kecamatan')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('kel_id');
            $table->foreign('kel_id')->references('id_kel')->on('kelurahan')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('total_suara');
            $table->integer('suara_tidak_sah');
            $table->integer('saksi_id');
            $table->foreign('saksi_id')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suara');
    }
}
