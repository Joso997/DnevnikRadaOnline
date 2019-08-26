<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoveznicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poveznicas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Sifra')->unique();
            $table->unsignedBigInteger('Id_Evidencija')->nullable();
            $table->unsignedBigInteger('Id_Materijala');
            $table->integer('Kolicina');
            $table->float('Cijena');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('poveznicas', function(Blueprint $table) {
            $table->foreign('Id_Evidencija')->references('id')->on('evidencijas');
            $table->foreign('Id_Materijala')->references('id')->on('skladistes');
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
        Schema::dropIfExists('poveznicas');
    }
}
