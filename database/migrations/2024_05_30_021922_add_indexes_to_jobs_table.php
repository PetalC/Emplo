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
            $table->index('status');
            $table->index('title');
            $table->index('position_type_id');
            $table->index('job_length_id');
            $table->index('start_date');
            $table->index('location_type_id');
            $table->index('offers_relocation');
            $table->index('offers_housing');
            $table->index('licencing_authority');
            $table->index('salary_min');
            $table->index('salary_max');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['title']);
            $table->dropIndex(['position_type_id']);
            $table->dropIndex(['job_length_id']);
            $table->dropIndex(['start_date']);
            $table->dropIndex(['location_type_id']);
            $table->dropIndex(['offers_relocation']);
            $table->dropIndex(['offers_housing']);
            $table->dropIndex(['licencing_authority']);
            $table->dropIndex(['salary_min']);
            $table->dropIndex(['salary_max']);
            $table->dropIndex(['created_at']);
        });
    }
};
