<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_educations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('study_field')->nullable();
            $table->string('university_graduation')->nullable();
            $table->string('year_of_graduation')->nullable();
            $table->integer('education_degree_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('education_degree_id')
                ->references('id')->on('education_degrees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::table('member_educations', function ($table) {
            $table->dropForeign('education_degree_id');
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('member_educations');
    }
}
