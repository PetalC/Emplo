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
        Schema::create('position_type_maps', function (Blueprint $table) {
            $table->id();
            $table->integer('position_type_id');
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
        Schema::dropIfExists('position_type_maps');
    }
};
