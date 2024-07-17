<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoordinatesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('longtitude')->after('zipcode')->default('');
            $table->string('latitude')->after('zipcode')->default('');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('longtitude')->after('zipcode')->default('');
            $table->string('latitude')->after('zipcode')->default('');
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
            $table->dropColumn('longtitude');
            $table->dropColumn('latitude');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('longtitude');
            $table->dropColumn('latitude');
        });
    }
}
