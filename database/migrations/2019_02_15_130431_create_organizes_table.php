<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('government_organize', ['yes', 'no'])->default('no');
//            ALTER TABLE `organizes` ADD `government_organize` ENUM('yes','no') NOT NULL DEFAULT 'no' AFTER `name`;
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
        Schema::dropIfExists('organizes');
    }
}
