<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('jobs', function (Blueprint $table) {
//            $table->string('required_licences_certs' )->nullable()->change();
            $table->dropColumn('salary');
            $table->string( 'licencing_authority' )->nullable()->after('required_licences_certs');
            $table->integer('salary_min' )->nullable()->after('licencing_authority');
            $table->integer('salary_max' )->nullable()->after('salary_min');
            $table->string('salary_type' )->nullable()->after('salary_max');
            $table->string( 'employment_type' )->after( 'offers_housing' )->change();
            $table->string( 'vacancy_reason' )->after( 'employment_type' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('jobs', function (Blueprint $table) {
            $table->integer('salary' )->nullable()->after('required_licences_certs');
            $table->dropColumn('salary_min');
            $table->dropColumn('salary_max');
            $table->dropColumn('salary_type');
            $table->dropColumn('licencing_authority');
            $table->dropColumn( 'vacancy_reason' );
        });
    }

};
