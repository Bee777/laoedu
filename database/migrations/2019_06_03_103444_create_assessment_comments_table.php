<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('text');
            $table->unsignedBigInteger('check_assessment_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('check_assessment_id')->references('id')->on('check_assessments')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('assessment_comments', function ($table) {
            $table->dropForeign('check_assessment_id');
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('assessment_comments');
    }
}
