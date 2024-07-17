<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->integer('sender')->default(0);
            $table->string('classification')->default('');
            $table->string('title');
            $table->text('body');
            $table->string('recipient');
            $table->string('status')->default('New');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_queue');
    }
}
