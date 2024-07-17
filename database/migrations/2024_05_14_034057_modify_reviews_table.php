<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('reviews');

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id' )->constrained()->onDelete('cascade');
            $table->integer('member_id' );
            $table->string('status' )->default( \App\Enums\ApplicationReviewStatuses::PENDING->value );
            $table->timestamps();
        } );
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {

        Schema::dropIfExists('reviews');

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('panel_id');
            $table->integer('member_id');
            $table->integer('application_id');
            $table->text('status');
            $table->timestamps();
        });

    }

};
