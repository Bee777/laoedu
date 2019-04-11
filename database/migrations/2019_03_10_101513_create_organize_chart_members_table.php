<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizeChartMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organize_chart_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->string('name');
            $table->string('surname');
            $table->string('position');//president, vice president, committee and others
            $table->string('university')->nullable();
            $table->mediumText('company')->nullable();
            $table->unsignedInteger('position_order');
            $table->unsignedInteger('organize_chart_range_id');
            $table->foreign('organize_chart_range_id')
                ->references('id')->on('organize_chart_ranges')
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
        Schema::table('organize_chart_members', function ($table) {
            $table->dropForeign('organize_chart_range_id');
        });
        Schema::dropIfExists('organize_chart_members');
    }
}
