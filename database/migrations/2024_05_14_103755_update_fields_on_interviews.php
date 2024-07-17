<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('interviews', function (Blueprint $table) {
            $table->string( 'address' )->nullable()->after('type' );
            $table->string( 'link' )->nullable()->after('address' );
            $table->json( 'panel_members' )->nullable()->after('link' );

            $table->text('notes' )->nullable()->after( 'type' )->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('interview_type');
            $table->dropColumn('address');
            $table->dropColumn('link');
            $table->dropColumn('panel_members');
        });
    }

};
