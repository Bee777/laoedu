<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_careers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('member_of_state', ['yes', 'no'])->default('no');
            $table->string('government_agency')->nullable();
            $table->date('start_date')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            //ALTER TABLE `member_careers` CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL;
            //ALTER TABLE `member_careers` CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL;
            $table->integer('organize_id')->unsigned()->nullable();//if not a member of state
            $table->integer('user_id')->unsigned();
            $table->foreign('organize_id')
                ->references('id')->on('organizes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::table('member_careers', function ($table) {
            $table->dropForeign('organize_id');
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('member_careers');
    }
}
