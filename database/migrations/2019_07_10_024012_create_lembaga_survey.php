<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLembagaSurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembaga_survey', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->integer('prov_id');
            $table->foreign('prov_id')->references('id_prov')->on('provinsi')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('kab_id');
            $table->foreign('kab_id')->references('id_kab')->on('kabupaten')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('kec_id');
            $table->foreign('kec_id')->references('id_kec')->on('kecamatan')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('alamat');
            $table->string('kontak');
            $table->boolean('status');
            $table->boolean('jenis');
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
        Schema::dropIfExists('lembaga_survey');
    }
}
