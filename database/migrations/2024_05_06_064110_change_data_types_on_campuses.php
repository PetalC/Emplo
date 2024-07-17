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
        Schema::table('campuses', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        } );


        Schema::table('campuses', function (Blueprint $table) {
            $table->float('latitude', 8)->nullable()->after( 'zipcode' );
            $table->float('longitude', 8)->nullable()->after( 'latitude' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->string('latitude')->default( '' )->change();
            $table->string('longitude')->default( '' )->change();
        });
    }
};
