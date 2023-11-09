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
        Schema::create('file_submissions', function (Blueprint $table) {
            $table->id();
            $table->longText('path')->nullable();
            $table->unsignedBigInteger('file_id')->index()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fiche_id');
            $table->integer('operateur_id');
            $table->timestamps();
            $table->foreign('file_id')->references('id')->on('fichiers')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('fiche_id')->references('id')->on('fiches')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_submissions');
    }
};
