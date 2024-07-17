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
        Schema::table('school_followers', function (Blueprint $table) {
            $table->renameColumn('school', 'school_id');
            $table->renameColumn('user', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_followers', function (Blueprint $table) {
            $table->renameColumn('school_id', 'school');
            $table->renameColumn('user_id', 'user');
        });
    }
};
