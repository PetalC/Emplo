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
            $table->string('branding_primary_color')->nullable()->after( 'job_boards' );
            $table->string('branding_secondary_color')->nullable()->after( 'branding_primary_color' );
            $table->string('branding_tertiary_color')->nullable()->after( 'branding_secondary_color' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campus_profiles', function (Blueprint $table) {
            $table->dropColumn('branding_primary_color');
            $table->dropColumn('branding_secondary_color');
            $table->dropColumn('branding_tertiary_color');
        });
    }
};
