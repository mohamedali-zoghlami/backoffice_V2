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
        Schema::create('fichiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('path');
            $table->longText('description')->nullable();
            $table->string('visibilite');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fiche_id');
            $table->string('section');
            $table->string('periodicite');
            $table->foreign('fiche_id')->references('id')->on('fiches')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('fichiers');
    }
};
