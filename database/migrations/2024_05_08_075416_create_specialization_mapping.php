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
        Schema::table('specialization_tags', function (Blueprint $table) {
            $table->dropColumn('ton');
        });

        Schema::create('subject_maps', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id');
            $table->string('ton')->default('');
            $table->string('ehq')->default('');
            $table->string('seek')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specialization_tags', function (Blueprint $table) {
            $table->string('ton')->default('')->after('label');
        });

        Schema::dropIfExists('subject_maps');
    }
};
