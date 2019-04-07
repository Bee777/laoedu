<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDictionaryCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hash_id')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->enum('type', ['guest', 'user'])->default('guest');
            $table->longText('text');
            $table->unsignedInteger('dictionary_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('dictionary_id')->references('id')->on('dictionaries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('dictionary_comments', function ($table) {
            $table->dropForeign('dictionary_id');
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('dictionary_comments');
    }
}
