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
       Schema::create('jobs', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('school_id')->nullable(false);
           $table->string('title');
           $table->text('description');
           $table->text('responsibilities');
           $table->text('required_licences_certs');
           $table->integer('salary');
           $table->unsignedInteger('employment_type');
           $table->timestamps();
       });
   }

   /**
    * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
