<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstname')->after('email');
            $table->string('lastname')->after('email');
            $table->integer('school')->default(0)->after('remember_token');
            $table->string('role')->default('')->after('remember_token');
            $table->string('school_role')->default('')->after('remember_token');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('role');
            $table->dropColumn('firstname');
            $table->dropColumn('lasttname');
        });
        
    }
}
