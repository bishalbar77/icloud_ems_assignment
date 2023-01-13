<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialTransDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_trans_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('financial_trans_id');
            $table->unsignedBigInteger('headid');
            $table->bigInteger('amount');
            $table->string('crdr');
            $table->string('head_name');
            $table->timestamps();
        });
        Schema::table('financial_trans_details',function($table){
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
            $table->foreign('financial_trans_id')->references('id')->on('financial_trans')->onDelete('cascade');
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
        Schema::dropIfExists('financial_trans_details');
    }
}
