<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('school')->default(0);
            $table->integer('job')->default(0);
            $table->string('zoho_books_id')->default('');
            $table->string('zoho_books_url')->default('');
            $table->string('status')->default('Pending');
            $table->decimal('amount')->unsigned()->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('school_invoices');
    }
}
