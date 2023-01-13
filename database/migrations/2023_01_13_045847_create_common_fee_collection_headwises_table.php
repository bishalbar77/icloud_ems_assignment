<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonFeeCollectionHeadwisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_fee_collection_headwises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('headid');
            $table->string('receiptId');
            $table->string('head_name');
            $table->bigInteger('amount');
            $table->timestamps();
        });
        Schema::table('common_fee_collection_headwises',function($table){
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
            $table->foreign('receiptId')->references('receipt_id')->on('common_fee_collections')->onDelete('cascade');
            $table->foreign('headid')->references('id')->on('fee_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_fee_collection_headwises');
    }
}
