<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('campuses', function (Blueprint $table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
            $table->dropColumn( 'address' );
            $table->dropColumn( 'city' );
            $table->dropColumn( 'state' );
            $table->dropColumn( 'zipcode' );
            $table->dropColumn( 'country' );

            $table->string( 'url_slug' )->after('school_id' )->unique()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->string( 'longitude' );
            $table->string( 'latitude' );
            $table->string( 'address' );
            $table->string( 'city' );
            $table->string( 'state' );
            $table->string( 'zipcode' );
            $table->string( 'country' );

            $table->dropColumn( 'url_slug' );
        });
    }
};
