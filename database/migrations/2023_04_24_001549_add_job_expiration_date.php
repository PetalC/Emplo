<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobExpirationDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->default(null)->after('updated_at');
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
            $table->dropColumn('expires_at');
        });
    }
}
