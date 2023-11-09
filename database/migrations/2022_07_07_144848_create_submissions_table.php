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
        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('form_id')->index()->nullable();
          //  $table->unsignedBigInteger('formHistoric_id')->index()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->json('formJson');
            $table->integer('operateur_id');
            $table->string('type');
            $table->string('historique')->comment('L->Live, H->Historic');
            $table->integer('year');
            $table->string('periodicity');
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('form_saves')->onDelete('CASCADE');
           // $table->foreign('formHistoric_id')->references('id')->on('form_historics')->onDelete('CASCADE');
            //$table->foreign('form_id')->references('id')->on('form_historics')->onDelete('CASCADE');
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
        Schema::dropIfExists('submissions');
    }
};
