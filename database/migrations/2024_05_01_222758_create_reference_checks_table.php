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
        Schema::create('reference_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referee_id');
            $table->unsignedBigInteger('candidate_id' );
            $table->unsignedBigInteger('application_id');
            $table->text('comment');
            $table->string('status');
            $table->timestamp('submitted_at' )->nullable();
            $table->timestamp('completed_at' )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reference_checks');
    }
};
