<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTingkattaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tingkattaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kegiatantak_id');
            $table->string('keterangan');
            $table->foreign('kegiatantak_id')->references('id')->on('kegiatantaks')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('tingkattaks');
    }
}
