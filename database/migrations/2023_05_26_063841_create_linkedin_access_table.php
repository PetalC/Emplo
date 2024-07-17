<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedinAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linkedin_access', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->integer('school');
            $table->text('access_token');
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('linkedin_id')->default('')->after('zoho_books_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linkedin_access');

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('linkedin_id');
        });
    }
}
