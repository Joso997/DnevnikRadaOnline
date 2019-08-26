<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kalendars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Id_Mjesta');
            $table->dateTime('Datum');
            $table->integer('Sifra')->unique()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('kalendars', function(Blueprint $table) {
            $table->foreign('Id_Mjesta')->references('id')->on('mjestas');
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
        Schema::dropIfExists('kalendars');
    }
}
