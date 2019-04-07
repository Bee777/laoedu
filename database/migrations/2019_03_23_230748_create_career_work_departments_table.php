<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerWorkDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_work_departments', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('department_id');
                $table->unsignedInteger('career_id');
                $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('career_id')->references('id')->on('member_careers')->onUpdate('cascade')->onDelete('cascade');
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

        Schema::table('career_work_departments', function ($table) {
            $table->dropForeign('department_id');
            $table->dropForeign('career_id');
        });
        Schema::dropIfExists('career_work_departments');
    }
}
