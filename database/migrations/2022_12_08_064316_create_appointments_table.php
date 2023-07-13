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
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doktor_id')->unsigned();
            $table->integer('hasta_id')->unsigned();
            $table->date('randevu_tarihi');
            $table->string('randevu_saati');
            $table->string('randevu_durumu');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('doktor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hasta_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
