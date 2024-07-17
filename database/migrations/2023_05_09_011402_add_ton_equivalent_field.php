<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTonEquivalentField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specialization_tags', function (Blueprint $table) {
            $table->string('ton')->default('')->after('label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('specialization_tags', function (Blueprint $table) {
            $table->dropColumn('ton');
        });
    }
}
