<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniversityBoardsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_posted_on_unistate')->after('is_posted_on_seek')->default(0);
            $table->unsignedTinyInteger('is_posted_on_uninat')->after('is_posted_on_seek')->default(0);
            $table->unsignedTinyInteger('is_posted_on_linkedin')->after('is_posted_on_seek')->default(0);
            $table->unsignedTinyInteger('is_posted_on_facebook')->after('is_posted_on_seek')->default(0);
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
            $table->dropColumn('is_posted_on_uninat');
            $table->dropColumn('is_posted_on_unistate');
            $table->dropColumn('is_posted_on_linkedin');
            $table->dropColumn('is_posted_on_facebook');
        });
    }
}
