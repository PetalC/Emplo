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
        Schema::table('states', function (Blueprint $table) {
            $table->float( 'latitude', 8 )->default( 0 )->after( 'iso2' );
            $table->float( 'longitude', 8 )->default( 0 )->after( 'latitude' );
            $table->geometry( 'geometry', subtype: 'multipolygon' )->nullable()->after( 'longitude' );
//            $table->spatialIndex( 'geometry' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
//            $table->dropIndex('states_geometry_index');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('geometry');
        });
    }
};
