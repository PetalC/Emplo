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
        Schema::table('school_user', function (Blueprint $table) {
            $table->timestamp('flagged_at')->nullable();
            $table->integer('flagged_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_user', function (Blueprint $table) {
            $table->dropColumn('flagged_at');
            $table->dropColumn('flagged_by');
        });
    }
};
