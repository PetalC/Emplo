<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoicePaymentColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_invoices', function (Blueprint $table) {
            $table->string('invoice_number')->default('')->after('zoho_books_id');
            $table->timestamp('paid_at')->nullable()->default(null)->after('updated_at');
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
            $table->dropColumn('invoice_number');
            $table->dropColumn('paid_at');
        });
    }
}
