<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('address_line1')->default('');
            $table->string('address_line2')->default('');
            $table->string('city')->default('');
            $table->string('state')->default('');
            $table->string('country')->default('Australia');
            $table->string('zipcode')->default('');
            $table->string('mobile_number')->default('');
            $table->string('alternate_number')->default('');
            $table->integer('years_of_experience')->default(0);
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
        Schema::dropIfExists('user_profiles');
    }
}
