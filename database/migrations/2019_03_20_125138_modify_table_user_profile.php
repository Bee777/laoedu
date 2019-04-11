<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTableUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $dropColumns = ['study_field', 'university_graduation_japan', 'year_of_graduation', 'member_of_state',
                'government_agency'];
            if (!Schema::hasColumn('user_profiles', 'marital_status')) {
                $table->enum('marital_status', ['none', 'single', 'married'])->default('none')->after('date_of_birth');
            }

            foreach ($dropColumns as $dropColumn) {

                if (Schema::hasColumn('user_profiles', $dropColumn)) {
                    $table->dropColumn($dropColumn);
                }
            }

            if (Schema::hasColumn('user_profiles', 'organize_id')) {
                $table->dropForeign('user_profiles_organize_id_foreign');
                $table->dropColumn('organize_id');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            //
        });
    }
}
