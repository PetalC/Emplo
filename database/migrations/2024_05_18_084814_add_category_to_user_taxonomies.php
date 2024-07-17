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
        Schema::table('user_taxonomies', function (Blueprint $table) {
            $table->id()->first();
            $table->string('category')->nullable()->after( 'taxonomy_id' );

            $table->unique(['taxonomy_id', 'user_id', 'category']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_taxonomies', function (Blueprint $table) {
            $table->dropUnique(['taxonomy_id', 'user_id', 'category']);
            $table->dropColumn('category');
        });
    }
};
