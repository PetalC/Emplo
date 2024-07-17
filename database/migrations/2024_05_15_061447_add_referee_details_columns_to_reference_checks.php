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
        Schema::table('reference_checks', function (Blueprint $table) {
            //
            $table->string('position')->nullable();
            $table->string('place_of_emplo')->nullable();
            $table->timestamp('work_with_date_start')->nullable();
            $table->timestamp('work_with_date_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reference_checks', function (Blueprint $table) {
            //
            $table->dropColumn([
                'position',
                'place_of_emplo',
                'work_with_date_start',
                'work_with_date_end',
            ]);
        });
    }
};
