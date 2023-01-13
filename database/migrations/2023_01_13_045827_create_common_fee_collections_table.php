<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonFeeCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_fee_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('entry_mode');
            $table->string('receipt_id')->unique();
            $table->string('transId');
            $table->string('admno');
            $table->string('rollno');
            $table->bigInteger('amount');
            $table->string('acadamicYear');
            $table->string('financialYear');
            $table->string('displayReceiptNo');
            $table->string('paid_date');
            $table->string('inactive');
            $table->timestamps();
        });
        Schema::table('common_fee_collections',function($table){
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
            $table->foreign('entry_mode')->references('entrymodeno')->on('entry_modes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_fee_collections');
    }
}
