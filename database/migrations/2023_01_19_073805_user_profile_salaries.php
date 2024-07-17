<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserProfileSalaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->text('brief')->after('zipcode')->nullable();
            $table->decimal('maximum_salary')->unsigned()->default(0)->after('zipcode');
            $table->decimal('minimum_salary')->unsigned()->default(0)->after('zipcode');
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
            $table->dropColumn('brief');
            $table->dropColumn('maximum_salary');
            $table->dropColumn('minimum_salary');
        });
    }
}
