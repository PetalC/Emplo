<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolProposition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('video_url')->after('zipcode')->default('');
            $table->longText('proposition')->after('zipcode');
            $table->string('logo')->after('zipcode')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('video_url');            
            $table->dropColumn('proposition');
            $table->dropColumn('logo');
        });
    }
}
