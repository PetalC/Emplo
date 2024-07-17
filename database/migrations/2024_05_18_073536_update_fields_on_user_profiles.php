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

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('right_to_work');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->boolean( 'right_to_work' )->default( false )->after( 'has_accepted_sustainability' );
            $table->unsignedInteger('citizenship_id' )->nullable()->after( 'right_to_work' );
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('right_to_work');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('citizenship_id');
            $table->string( 'right_to_work' );
        });
    }
};
