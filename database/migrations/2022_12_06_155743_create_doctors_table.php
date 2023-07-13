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
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('doktor_tc')->unique();
            $table->string('doktor_adi');
            $table->string('doktor_cin');
            $table->string('doktor_adres')->nullable();
            $table->string('doktor_tel');
            $table->date('doktor_dt');
            $table->string('doktor_uzmanlik')->nullable();
            $table->integer('klinik_id')->unsigned();
            $table->timestamps();
            $table->foreign('klinik_id')->references('id')->on('clinics');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
