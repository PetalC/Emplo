<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->string('content')->default('');
            $table->string('classification')->default('general');
            $table->string('link')->default('');
            $table->unsignedTinyInteger('is_read')->default(0);
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
        Schema::dropIfExists('alert_messages');
    }
}
