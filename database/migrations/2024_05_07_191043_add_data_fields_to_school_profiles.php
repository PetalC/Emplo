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
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->integer('student_enrollments')->nullable()->after( 'youtube_embed_url' );
            $table->integer('staff_size')->nullable()->after( 'student_enrollments' );
            $table->integer('teacher_size')->nullable()->after( 'staff_size' );
            $table->string('school_type')->nullable()->after( 'teacher_size' );
            $table->string('school_gender')->nullable()->after( 'school_type' );
            $table->string('school_sector')->nullable()->after( 'school_gender' );
            $table->string('school_religion')->nullable()->after( 'school_sector' );
            $table->string('school_curriculum')->nullable()->after( 'school_religion' );
            $table->string('school_area')->nullable()->after( 'school_curriculum' );
            $table->text('quote')->nullable()->after( 'school_area' );
            $table->json( 'social_profiles' )->nullable()->after( 'quote' );
            $table->json( 'job_boards' )->nullable()->after( 'social_profiles' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('student_enrollments');
            $table->dropColumn('staff_size');
            $table->dropColumn('teacher_size');
            $table->dropColumn('school_type');
            $table->dropColumn('school_gender');
            $table->dropColumn('school_sector');
            $table->dropColumn('school_religion');
            $table->dropColumn('school_curriculum');
            $table->dropColumn('school_area');
            $table->dropColumn('quote');
            $table->dropColumn('social_profiles');
            $table->dropColumn('job_boards');
        });
    }
};
