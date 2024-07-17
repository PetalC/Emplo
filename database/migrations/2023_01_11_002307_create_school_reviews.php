<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('school');
            $table->integer('user');
            $table->string('title');
            $table->text('description');
            $table->string('would_recommend')->default('');
            $table->integer('job_security')->default(0);
            $table->integer('work_life_balance')->default(0);
            $table->integer('company_culture')->default(0);
            $table->integer('environment')->default(0);
            $table->integer('salary_benefits')->default(0);
            $table->integer('career_growth')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_reviews');
    }
}
