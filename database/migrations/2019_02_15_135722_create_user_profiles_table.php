<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {

            $table->increments('id');
            $table->string('phone_number')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->text('current_address')->nullable();
            $table->date('date_of_birth')->nullable()->default(null);
            //ALTER TABLE `user_profiles` CHANGE `date_of_birth` `date_of_birth` DATE NULL DEFAULT NULL;
            $table->longText('description')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::table('user_profiles', function ($table) {
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('user_profiles');
    }
}
