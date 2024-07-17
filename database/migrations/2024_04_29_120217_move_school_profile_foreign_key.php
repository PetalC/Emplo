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
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropForeign(['campus_id']);
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('campus_id');
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->foreignId('campus_id')->after( 'id' )->constrained('campuses' )->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropForeign(['campus_id']);
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('campus_id');
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->foreignId('campus_id')->after( 'id' )->constrained('schools' )->onDelete('cascade');
        });
    }
};
