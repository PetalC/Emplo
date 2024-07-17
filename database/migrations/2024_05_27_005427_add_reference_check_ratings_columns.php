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
            $table->smallInteger('know_student')->nullable();
            $table->smallInteger('know_content')->nullable();
            $table->smallInteger('plan_for_teaching')->nullable();
            $table->smallInteger('create_learning')->nullable();
            $table->smallInteger('assess_learning')->nullable();
            $table->smallInteger('professionalism')->nullable();
            $table->smallInteger('colleague_engagement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reference_checks', function (Blueprint $table) {
            $table->dropColumn('know_student');
            $table->dropColumn('know_content');
            $table->dropColumn('plan_for_teaching');
            $table->dropColumn('create_learning');
            $table->dropColumn('assess_learning');
            $table->dropColumn('professionalism');
            $table->dropColumn('colleague_engagement');
        });
    }
};
