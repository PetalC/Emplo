<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobBoardsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_posted_on_seek')->default(0)->after('is_paused');
            $table->unsignedTinyInteger('is_posted_on_indeed')->default(0)->after('is_paused');
            $table->unsignedTinyInteger('is_posted_on_ton')->default(0)->after('is_paused');
            $table->unsignedTinyInteger('is_posted_on_ehq')->default(0)->after('is_paused');
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
            $table->dropColumn('is_posted_on_seek');
            $table->dropColumn('is_posted_on_indeed');
            $table->dropColumn('is_posted_on_ton');
            $table->dropColumn('is_posted_on_ehq');
        });
    }
}
