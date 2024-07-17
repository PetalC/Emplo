<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAdverts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_adverts', function (Blueprint $table) {
            $table->id();
            $table->integer('school');
            $table->string('title');
            $table->text('description');
            $table->string('time_requirement')->default('Full-Time');
            $table->integer('experience_requirement')->default(0);
            $table->decimal('minimum_salary')->unsigned()->default(0);
            $table->decimal('maximum_salary')->unsigned()->default(0);
            $table->string('currency')->default('AUD');
            $table->unsignedTinyInteger('is_paused')->default(0);
            $table->timestamp('closed_at')->default(NULL);
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
        Schema::dropIfExists('job_adverts');
    }
}
