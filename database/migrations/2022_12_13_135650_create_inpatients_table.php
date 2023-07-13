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
        Schema::create('inpatients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doktor_id')->unsigned();
            $table->integer('hasta_id')->unsigned();
            $table->date('yatis_tarihi');
            $table->string('yatis_nedeni');
            $table->date('cikis_tarihi')->nullable();
            $table->string('yatis_durumu');
            $table->integer('oda_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('doktor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hasta_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('oda_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inpatients');
    }
};
