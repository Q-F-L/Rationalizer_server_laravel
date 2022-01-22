<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('topic');
            $table->string('title');
            $table->string('now_description');
            $table->string('now_video');
            $table->string('now_photo');
            $table->string('need_description');
            $table->string('need_video');
            $table->string('need_photo');
            $table->string('will_description');
            $table->string('rating');
            $table->unsignedBigInteger('discussion_id');

            $table->foreign('discussion_id')->references('id')->on('discussions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
}
