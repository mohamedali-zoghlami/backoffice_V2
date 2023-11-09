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
        Schema::create('submission_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_id');
            $table->json('formJson')->nullable(); 
            $table->timestamps();
            $table->foreign('submission_id')->references('id')->on('submissions')->onDelete('CASCADE');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission_temps');
    }
};
