<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePadresHijos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padres_hijos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('padre_id');
            $table->unsignedBigInteger('hijo_id');
            $table->enum('relation', ['padre', 'madre', 'tutor']);
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
        Schema::dropIfExists('padres_hijos');
    }
}
