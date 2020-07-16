<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategoritak_id');
            $table->unsignedBigInteger('pilartak_id');
            $table->unsignedBigInteger('kegiatantak_id');
            $table->unsignedBigInteger('tingkattak_id');
            $table->integer('score')->default(0);
            $table->foreign('kegiatantak_id')->references('id')->on('kegiatantaks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tingkattak_id')->references('id')->on('tingkattaks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kategoritak_id')->references('id')->on('kategoritaks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pilartak_id')->references('id')->on('pilartaks')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('taks');
    }
}
