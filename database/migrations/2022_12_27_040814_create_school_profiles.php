<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('classification')->default('');
            $table->text('description');
            $table->string('address')->default('');
            $table->string('country')->default('');
            $table->string('state')->default('');
            $table->string('city')->default('');
            $table->string('zipcode')->default('');
            $table->string('mobile_number')->default('');
            $table->string('alternate_number')->default('');
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
        Schema::dropIfExists('school_profiles');
    }
}
