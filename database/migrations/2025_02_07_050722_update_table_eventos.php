<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Agregar la columna type_event como clave foránea
            $table->unsignedBigInteger('type_event'); // o el tipo de dato correspondiente
            //$table->foreign('type_event')->references('id')->on('type_event')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna
            $table->dropForeign(['type_event']);
            $table->dropColumn('type_event');
        });
    }
}
