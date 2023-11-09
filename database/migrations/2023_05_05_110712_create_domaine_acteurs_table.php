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
        Schema::create('domaine_acteurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domaine_id');
            $table->unsignedBigInteger('acteur_id');
            $table->foreign('domaine_id')->references('id')->on('domaines')->onDelete('cascade');
            $table->foreign('acteur_id')->references('id')->on('acteurs')->onDelete('cascade');
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
        Schema::dropIfExists('domaine_acteurs');
    }
};
