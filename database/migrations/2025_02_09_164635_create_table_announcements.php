<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAnnouncements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('sender_user_id');
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->string('subject');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')
                ->references('id') // permission id
                ->on('schools')
                ->onDelete('cascade');
            $table->foreign('sender_user_id')
                ->references('id') // permission id
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('to_user_id')
                ->references('id') // permission id
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
