<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumMessageAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('forum_message_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forum_message_id');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->timestamps();

            $table->foreign('forum_message_id')->references('id')->on('forum_messages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('forum_message_attachments');
    }
}
