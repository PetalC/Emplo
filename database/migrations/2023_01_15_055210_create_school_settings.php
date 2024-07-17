<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('school');
            $table->unsignedTinyInteger('send_budget_reached')->default(1);
            $table->unsignedTinyInteger('send_new_candidate')->default(1);
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
        Schema::dropIfExists('school_settings');
    }
}
