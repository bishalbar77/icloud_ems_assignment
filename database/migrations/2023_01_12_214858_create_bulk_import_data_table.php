<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkImportDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('bulk_import_data', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('academic_year');
            $table->string('session');
            $table->string('alloted_category')->nullable();
            $table->string('voucher_type');
            $table->string('voucher_no');
            $table->string('roll_no');
            $table->string('admno_unique_id');
            $table->string('status');
            $table->string('fee_category');
            $table->string('faculty');
            $table->string('program');
            $table->string('department');
            $table->string('batch');
            $table->string('receipt_no')->nullable();
            $table->string('fee_head');
            $table->string('due_amount');
            $table->string('paid_amount');
            $table->string('concession_amount');
            $table->string('scholarship_amount');
            $table->string('reverse_concession_amount');
            $table->string('write_off_amount');
            $table->string('adjusted_amount');
            $table->string('refund_amount');
            $table->string('fund_transfer_amount');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('bulk_import_data');
    }
}
