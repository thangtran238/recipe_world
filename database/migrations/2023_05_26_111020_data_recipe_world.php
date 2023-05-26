<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up()
    {
        // Create users table
        Schema::create('obtainers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->text('bio')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->timestamps();
        });

        // Create posts table
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('obtainers_id');
            $table->foreign('obtainers_id')->references('id')->on('obtainers');
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // Create comments table
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('obtainers_id');
            $table->foreign('obtainers_id')->references('id')->on('obtainers');
            $table->unsignedInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->text('content');
            $table->timestamps();
        });

        // Create likes table
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('obtainers_id');
            $table->foreign('obtainers_id')->references('id')->on('obtainers');
            $table->unsignedInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->timestamps();
        });

        // Create followers table
        Schema::create('followers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('obtainers_id');
            $table->foreign('obtainers_id')->references('id')->on('obtainers');
            $table->unsignedInteger('follower_obtainers_id');
            $table->foreign('follower_obtainers_id')->references('id')->on('obtainers');
            $table->timestamps();
        });

        // Create messages table
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('obtainers');
            $table->unsignedInteger('recipient_id');
            $table->foreign('recipient_id')->references('id')->on('obtainers');
            $table->text('content');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop tables in reverse order
        Schema::dropIfExists('messages');
        Schema::dropIfExists('followers');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('obtainers');
    }
};

