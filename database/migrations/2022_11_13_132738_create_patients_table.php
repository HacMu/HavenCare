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
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('hasta_tc')->unique();
            $table->string('hasta_adi');
            $table->string('hasta_cin')->nullable();
            $table->string('hasta_adres')->nullable();
            $table->string('hasta_tel');
            $table->string('hasta_kan_grubu')->nullable();
            $table->string('hasta_kilo')->nullable();
            $table->string('hasta_boyu')->nullable();
            $table->date('hasta_dt');
            $table->string('hasta_image')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('patients');
    }
};
