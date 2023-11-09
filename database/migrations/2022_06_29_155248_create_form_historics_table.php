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
        Schema::create('form_historics', function (Blueprint $table) {
            $table->id();          
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('user_id');
            $table->json('formJson')->nullable();
            $table->string('name');
            $table->string('section');
            $table->string('visibility');
            $table->string('periodicite');
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('form_saves');
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
        Schema::dropIfExists('form_historics');
    }
};
