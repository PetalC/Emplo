<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolApprovalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_reviews', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_approved')->after('user')->default(0);
            $table->string('lastname')->after('user')->default('');
            $table->string('firstname')->after('user')->default('');
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
            $table->dropColumn('is_approved');
            $table->dropColumn('lastname');
            $table->dropColumn('firstname');
        });
    }
}
