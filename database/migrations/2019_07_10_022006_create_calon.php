<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pemilihan_id')->unsigned();
            $table->foreign('pemilihan_id')->references('id')->on('pemilihan')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('calon_utama_nama');
            $table->string('calon_wakil_nama');
            $table->string('calon_nomor_urut');
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
        Schema::dropIfExists('calon');
    }
}
