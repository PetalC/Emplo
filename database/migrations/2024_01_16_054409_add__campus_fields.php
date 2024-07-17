<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampusFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->integer('campus')->default(0)->after('school');
        });

        Schema::table('school_locations', function (Blueprint $table) {
            $table->string('longitude')->default('')->after('zipcode');
            $table->string('latitude')->default('')->after('zipcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->dropColumn('campus');
        });

        Schema::table('school_locations', function (Blueprint $table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
    }
}
