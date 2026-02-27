<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('materia_id');
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('disabled_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['school_id', 'materia_id', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
