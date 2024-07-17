<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWithdrawApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_candidates', function (Blueprint $table) {
            $table->timestamp('withdrawn_at')->nullable()->default(NULL)->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_candidates', function (Blueprint $table) {
            $table->dropColumn('withdrawn_at');
        });
    }
}
