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
        Schema::table('job_candidates', function (Blueprint $table) {
            $table->dropColumn('rejected_at');
            // Doctrine failing to modify timestamp column
            // @see https://github.com/doctrine/dbal/issues/2558
            // Workaround is to drop column and rebuild with nullable
            // BEWARE - this will wipe any rejected_at data
//            $table->timestamp('rejected_at')->nullable()->change();
//            $table->timestamp('rejected_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_candidates', function (Blueprint $table) {
            $table->timestamp('rejected_at')->default(NULL);
        });
    }
};
