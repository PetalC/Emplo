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
            $table->text('child_protection_details')->nullable();
            $table->text('performance_related_details')->nullable();
            $table->text('reason_not_with_children_details')->nullable();
            $table->smallInteger('recent_child_protection')->nullable();
            $table->boolean('recommended')->nullable()->default(1);
            $table->text('recommended_reason')->nullable();
            $table->boolean('rehire')->nullable()->default(1);
            $table->text('rehire_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reference_checks', function (Blueprint $table) {
            $table->dropColumn('child_protection_details');
            $table->dropColumn('performance_related_details');
            $table->dropColumn('reason_not_with_children_details');
            $table->dropColumn('recent_child_protection');
            $table->dropColumn('recommended');
            $table->dropColumn('recommended_reason');
            $table->dropColumn('rehire');
            $table->dropColumn('rehire_reason');
        });
    }
};
