<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckAssessmentSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_assessment_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assessment_id');
            $table->enum('score', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->enum('status', ['checking', 'success'])->default('checking');
            $table->foreign('assessment_id')
                ->references('id')->on('check_assessments')
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
        Schema::table('check_assessment_sections', function ($table) {
            $table->dropForeign('assessment_id');
        });
        Schema::dropIfExists('check_assessment_sections');
    }
}
