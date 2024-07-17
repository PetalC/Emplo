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
        Schema::table('users', function (Blueprint $table) {
            // $table->dropColumn('name'); // name column dropped in add_role_user_table migration
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('phone_number')->nullable();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->string('name'); // name column dropped in add_role_user_table migration
            $table->string('firstname')->after('email');
            $table->string('lastname')->after('email');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone_number');
            $table->dropColumn('data');
        });
    }
};
