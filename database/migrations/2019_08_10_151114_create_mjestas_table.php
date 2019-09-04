<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMjestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mjestas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('NazivMjesta');
            $table->string('Adresa');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->unique(['NazivMjesta', 'Adresa', 'user_id']);
            $table->boolean('hasDetails');
        });

        Schema::table('mjestas', function(Blueprint $table) {
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
        Schema::dropIfExists('mjestas');
    }
}
