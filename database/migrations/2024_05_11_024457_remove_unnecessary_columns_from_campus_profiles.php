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
        Schema::table('campus_profiles', function (Blueprint $table) {
            $table->dropColumn('school_area');
            $table->dropColumn('school_type');
            $table->dropColumn('school_religion');
            $table->dropColumn('school_gender');
            $table->dropColumn('school_sector');
            $table->dropColumn('school_curriculum');
            $table->dropColumn( 'logo' );
            $table->dropColumn( 'banner' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campus_profiles', function (Blueprint $table) {
            $table->string('school_area')->nullable();
            $table->string('school_type')->nullable();
            $table->string('school_religion')->nullable();
            $table->string( 'school_gender' )->nullable();
            $table->string( 'school_sector' )->nullable();
            $table->string( 'school_curriculum' )->nullable();
            $table->string( 'logo' )->nullable();
            $table->string( 'banner' )->nullable();
        });
    }
};
