<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolFieldsOnHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_profile_history', function (Blueprint $table) {
            $table->string('classification')->default('');
            $table->string('address')->default('');
            $table->string('state')->default('');
            $table->string('city')->default('');
            $table->string('zipcode')->default('');
            $table->string('video_url')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_profile_history', function (Blueprint $table) {
            $table->dropColumn('classification');
            $table->dropColumn('address');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('zipcode');
            $table->dropColumn('video_url');
        });
    }
}
