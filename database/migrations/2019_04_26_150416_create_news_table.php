<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['pending', 'close', 'open'])->default('open');
            $table->enum('type', ['news', 'remark', 'activity', 'scholarship' ])->default('news');
            $table->string('title',300);
            $table->string('image',200);
            $table->longText('description',50000);
            $table->timestamp('deadline')->nullable()->default(null);
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->double('view')->default(0);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
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
        Schema::table('news', function ($table) {
            $table->dropForeign('user_id');
            $table->dropForeign('news_categories_id');
        });
        Schema::dropIfExists('news');
    }
}
