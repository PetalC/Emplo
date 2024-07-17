<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolProfileHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_profile_history', function (Blueprint $table) {
            $table->id();
            $table->integer('school')->default(0);
            $table->text('description');
            $table->text('proposition');
            $table->text('comments');
            $table->string('status')->default('Pending');
            $table->timestamp('reviewed_at')->nullable();
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
        Schema::dropIfExists('school_profile_history');
    }
}
