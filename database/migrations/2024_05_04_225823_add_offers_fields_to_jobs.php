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
        Schema::table('jobs', function (Blueprint $table) {
            $table->boolean( 'offers_relocation' )->default( false )->after( 'salary' );
            $table->boolean( 'offers_housing' )->default( false )->after( 'offers_relocation' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn( 'offers_relocation' );
            $table->dropColumn( 'offers_housing' );
        });
    }
};
