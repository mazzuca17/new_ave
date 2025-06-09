<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingSchemaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_schema_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_grading_schemes');
            $table->string('label');
            $table->integer('from');
            $table->integer('to');
            $table->string('status');
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
        Schema::dropIfExists('grading_schema_details');
    }
}
