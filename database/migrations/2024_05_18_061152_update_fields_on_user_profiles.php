<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('user_profiles', function (Blueprint $table) {
//            $table->dropColumn('user' );
            $table->boolean('suitable_for_work' )->after( 'years_of_experience' )->default( false );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->integer('user');
            $table->dropColumn('suitable_for_work');
        } );
    }

};
