<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('fee_head_type');
            $table->unsignedBigInteger('fee_category_id');
            $table->unsignedBigInteger('collection_id');
            $table->string('f_name');
            $table->string('fee_type_ledger');
            $table->timestamps();
        });
        Schema::table('fee_types',function($table){
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('fee_head_type')->references('module_id')->on('modules')->onDelete('cascade');
            $table->foreign('fee_category_id')->references('id')->on('fee_categories')->onDelete('cascade');
            $table->foreign('collection_id')->references('id')->on('fee_collection_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_types');
    }
}
