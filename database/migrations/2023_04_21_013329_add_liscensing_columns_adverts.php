<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiscensingColumnsAdverts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->string('liscensing_authority')->default('')->after('currency');
            $table->unsignedTinyInteger('is_working_with_children')->default(0)->after('is_paused');
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
            $table->dropColumn('liscensing_authority');
            $table->dropColumn('is_working_with_children');
        });
    }
}
