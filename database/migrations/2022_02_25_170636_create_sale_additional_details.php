<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleAdditionalDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_additional_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sale_detail_id')->index();
            $table->uuid('additional_id')->index();
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sale_detail_id')->references('id')->on('sale_details');
            $table->foreign('additional_id')->references('id')->on('additionals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_additional_details');
    }
}
