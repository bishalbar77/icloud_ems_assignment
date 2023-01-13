<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_trans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('entry_mode');
            $table->string('tranid');
            $table->string('admno');
            $table->bigInteger('amount');
            $table->string('crdr');
            $table->string('tranDate');
            $table->string('acadYear');
            $table->string('voucherno');
            $table->string('type_of_concession')->nullable();
            $table->timestamps();
        });
        Schema::table('financial_trans',function($table){
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
        Schema::dropIfExists('financial_trans');
    }
}
