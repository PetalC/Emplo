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
        Schema::rename('right_to_works', 'citizenship_types');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('citizenship_types', 'right_to_works');
    }
};
