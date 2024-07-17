<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_locations', function (Blueprint $table) {
            $table->id();
            $table->integer('school');
            $table->string('address')->default('');
            $table->string('city')->default('');
            $table->string('state')->default('');
            $table->string('country')->default('Australia');
            $table->string('zipcode')->default('');
            $table->unsignedTinyInteger('is_primary')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('school_locations');
    }
}
