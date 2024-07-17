<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolSocials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_settings', function (Blueprint $table) {
            $table->string('instagram')->default('')->after('send_new_candidate');
            $table->string('twitter')->default('')->after('send_new_candidate');
            $table->string('facebook')->default('')->after('send_new_candidate');
            $table->string('linkedin')->default('')->after('send_new_candidate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_settings', function (Blueprint $table) {
            $table->dropColumn('instagram');
            $table->dropColumn('twitter');
            $table->dropColumn('facebook');
            $table->dropColumn('linkedin');
        });
    }
}
