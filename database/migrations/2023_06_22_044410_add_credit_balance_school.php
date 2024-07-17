<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditBalanceSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->decimal('credit_balance')->unsigned()->after('linkedin_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('credit_balance');
        });
    }
}
