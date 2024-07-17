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
        Schema::table('schools', function (Blueprint $table) {
            $table->string('zoho_id')->default('')->after('id');
            $table->string('classification')->default('')->after('name');
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('zoho_id');
            $table->dropColumn('zoho_books_id');
            $table->dropColumn('linkedin_id');
            $table->dropColumn('mobile_number');
            $table->dropColumn('alternate_number');
            $table->dropColumn('classification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('zoho_id');
            $table->dropColumn('classification');
        });

        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('linkedin_id')->default('')->after('id');
            $table->string('zoho_books_id')->default('')->after('id');
            $table->string('zoho_id')->default('')->after('id');
            $table->string('mobile_number')->default('');
            $table->string('alternate_number')->default('');
            $table->string('classification')->default('')->after('name');
        });
    }
};
