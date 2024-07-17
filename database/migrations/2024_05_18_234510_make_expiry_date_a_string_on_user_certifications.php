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
        Schema::table('user_certifications', function (Blueprint $table) {
            $table->string('expires_at' )->nullable()->after( 'is_valid' )->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_certifications', function (Blueprint $table) {
            $table->date('expires_at' )->change();
        });
    }
};
