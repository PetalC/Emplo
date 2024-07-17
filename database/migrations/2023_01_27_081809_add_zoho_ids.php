<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZohoIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zoho_id')->default('')->after('lastname');
        });

        Schema::table('job_adverts', function (Blueprint $table) {
            $table->string('zoho_id')->default('')->after('school');
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('zoho_id')->default('')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('zoho_id');
        });

        Schema::table('job_adverts', function (Blueprint $table) {
            $table->dropColumn('zoho_id');
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('zoho_id');
        });
    }
}
