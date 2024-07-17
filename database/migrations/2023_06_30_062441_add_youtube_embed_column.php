<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYoutubeEmbedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->text('youtube_embed_url')->after('video_url')->nullable();
        });

        Schema::table('school_profile_history', function (Blueprint $table) {
            $table->text('youtube_embed_url')->after('video_url')->nullable();
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
            $table->dropColumn('youtube_embed_url');
        });

        Schema::table('school_profile_history', function (Blueprint $table) {
            $table->dropColumn('youtube_embed_url');
        });
    }
}
