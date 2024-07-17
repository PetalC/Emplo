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
        Schema::table( 'user_certifications', function (Blueprint $table) {
            $table->dropColumn( 'name' );
            $table->dropColumn( 'received_at' );

            $table->string( 'certification' )->after( 'user_id' );
            $table->string( 'certification_id' )->after( 'certification' );
            $table->date( 'expires_at' )->after( 'certification_id' );
            $table->boolean( 'is_valid' )->default( false )->after( 'certification_id' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table( 'user_certifications', function (Blueprint $table) {
            $table->string( 'name' )->after( 'id' );
            $table->timestamp( 'received_at' )->after( 'user_id' );

            $table->dropColumn( 'certification' );
            $table->dropColumn( 'certification_id' );
            $table->dropColumn( 'is_valid' );
        });
    }
};
