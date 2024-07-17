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
        Schema::table('job_adverts', function (Blueprint $table) {
            $table->renameColumn( 'school', 'school_id' );
            $table->renameColumn( 'campus', 'campus_id' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {}
};
