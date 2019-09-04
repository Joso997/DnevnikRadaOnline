<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkladistesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skladistes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Sifra')->unique();
            $table->string('NazivMaterijala');
            $table->string('Prodavac')->nullable();
            $table->integer('Kolicina');
            $table->string('MjernaJedinica')->nullable();
            $table->float('Cijena')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->unique(['Sifra', 'NazivMaterijala', 'Prodavac', 'user_id']);
        });

        Schema::table('skladistes', function(Blueprint $table) {
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
        Schema::dropIfExists('skladistes');
    }
}
