<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('price')->after( 'name' )->nullable();
            $table->string('retail_price')->after( 'price' )->nullable();
            $table->text( 'description' )->after( 'retail_price' )->nullable();
            $table->integer('order' )->after( 'description' )->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('retail_price');
            $table->dropColumn('price');
            $table->dropColumn('description');
            $table->dropColumn('order');
        });
    }
};
