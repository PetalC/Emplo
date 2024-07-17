<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('campus_profiles', function (Blueprint $table) {
            $table->geometry('location', subtype: 'point')->nullable()->after('longitude' );
//            $table->spatialIndex('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('campus_profiles', function (Blueprint $table) {
            $table->dropColumn('location');
//            $table->dropIndex('campus_profiles_location_index');
        });
    }

};
