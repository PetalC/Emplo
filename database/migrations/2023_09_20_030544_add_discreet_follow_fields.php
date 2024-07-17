<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscreetFollowFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_followers', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_confidential')->default(0)->after('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_followers', function (Blueprint $table) {
            $table->dropColumn('is_confidential');
        });
    }
}
