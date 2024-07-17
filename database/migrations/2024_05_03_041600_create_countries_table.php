<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso3');
            $table->string('iso2');
            $table->string('phonecode');
            $table->string('capital');
            $table->string('currency');
            $table->string('region');
            $table->string('subregion');
            $table->string('emoji');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
