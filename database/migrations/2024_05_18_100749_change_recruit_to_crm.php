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
            $table->renameColumn('zoho_id', 'zoho_crm_id');
            $table->string('zoho_recruit_id')->default('');
            $table->dropColumn('classification');
        });

        Schema::dropIfExists('zoho_recruit_imports');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->renameColumn('zoho_crm_id', 'zoho_id');
            $table->dropColumn('zoho_recruit_id');
            $table->string('classification')->default('');
        });

        Schema::create('zoho_recruit_imports', function (Blueprint $table) {
            $table->id();
            $table->string('recruit_id')->default('');
            $table->string('school_name')->default('');
            $table->string('email')->default('');
            $table->string('password')->default('');
            $table->timestamps();
        });
    }
};
