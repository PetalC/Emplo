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

        if( Schema::hasColumn('user_profiles', 'longtitude') ) {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->dropColumn( 'longtitude' );
            });
        }

        if( Schema::hasColumn('user_profiles', 'longitude') ) {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->dropColumn('longitude' );
            });
        }

        if( Schema::hasColumn('user_profiles', 'latitude') ) {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->dropColumn('latitude' );
            });
        }

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->float('latitude', 8)->nullable()->after( 'zipcode' );
            $table->float('longitude', 8)->nullable()->after( 'latitude' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('latitude' )->nullable()->change();
            $table->string('longtitude' )->nullable()->change();
        });
    }
};
