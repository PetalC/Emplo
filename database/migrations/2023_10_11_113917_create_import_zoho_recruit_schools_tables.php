<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportZohoRecruitSchoolsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoho_recruit_imports', function (Blueprint $table) {
            $table->id();
            $table->string('recruit_id')->default('');
            $table->string('school_name')->default('');
            $table->string('email')->default('');
            $table->string('password')->default('');
            $table->timestamps();
        });

        Schema::create('zoho_import_process', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('');
            $table->integer('page')->default(0);
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
        Schema::dropIfExists('zoho_recruit_imports');
        Schema::dropIfExists('zoho_import_process');
    }
}
