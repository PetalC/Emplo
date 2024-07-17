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
            $table->text( 'description' )->nullable()->change();
            $table->text( 'proposition' )->nullable()->change();
        } );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {}
};
