<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_educations', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->string('school');
            $table->timestamp('started_at')->nullable()->default(NULL);
            $table->timestamp('ended_at')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_educations');
    }
}
