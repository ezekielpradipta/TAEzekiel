<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mahasiswa;
class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dosen_id');
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('nim');
            $table->integer('totaltak')->default(0);
            $table->enum('gender',['L','P'])->nullable();
            $table->string('image')->default(Mahasiswa::USER_PHOTO_DEFAULT);
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
        Schema::dropIfExists('mahasiswas');
    }
}
