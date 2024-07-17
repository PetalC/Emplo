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
        Schema::create('school_user_flags', function (Blueprint $table) {
            $table->foreignId('user_id')->references( 'id' )->on( 'users' )->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->references( 'id' )->on( 'schools' )->constrained()->cascadeOnDelete();
            $table->foreignId('flagged_by')->nullable()->references( 'id' )->on( 'users' )->nullOnDelete();
            $table->timestamp('flagged_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_user_flags');
    }
};
