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
        Schema::create('job_board_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->string('job_board' );
            $table->string( 'url' )->nullable();
            $table->integer( 'credit_cost' )->default( 0 );
            $table->boolean( 'is_posted' )->default( false );
            $table->dateTime( 'posted_at' )->nullable();
            $table->json( 'posted_response' )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_board_postings');
    }
};
