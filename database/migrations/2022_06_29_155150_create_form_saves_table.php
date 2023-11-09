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
        Schema::create('form_saves', function (Blueprint $table) {
            $table->id();
            $table->json('formJson'); 
            $table->unsignedBigInteger('user_id');
            //$table->String('name')->nullable();
            $table->unsignedBigInteger('fiche_id');
            $table->string('name');
            $table->string('section');
            $table->string('visibility');
            $table->string('periodicite');
             //$table->integer('fiche_id');
            $table->timestamps();
            $table->foreign('fiche_id')->references('id')->on('fiches')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_saves');
    }
};
