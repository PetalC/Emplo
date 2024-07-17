<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobTypeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->string('length')->default('')->after('title');
            $table->string('position_type')->default('')->after('title');
            $table->datetime('start_date')->nullable()->default(NULL)->after('title');
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
            $table->dropColumn('length');
            $table->dropColumn('position_type');
            $table->dropColumn('start_date');
        });
    }
}
