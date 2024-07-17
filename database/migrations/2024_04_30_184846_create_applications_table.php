<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id( 'id' )->primary();
            $table->ulid( 'ulid' );
            $table->integer( 'job_id' );
            $table->integer('user_id' );
            $table->json('specialities' )->nullable();
            $table->json('registration')->nullable();
            $table->tinyInteger('right_to_work')->nullable();
            $table->string('current_location')->nullable();
            $table->string('job_type')->nullable();
            $table->string('referred_method')->nullable();
            $table->string( 'status' )->default('PENDING' );
            $table->timestamp('shortlisted_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
