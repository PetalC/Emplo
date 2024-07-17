<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('user_saved_job', function ( Blueprint $table ) {
            $table->foreignId( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
            $table->foreignId( 'job_id' )->references( 'id' )->on( 'jobs' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('user_saved_job');
    }

};
