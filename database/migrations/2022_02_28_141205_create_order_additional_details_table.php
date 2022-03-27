<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAdditionalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_additional_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_detail_id')->index();
            $table->uuid('additional_id')->index();
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_detail_id')->references('id')->on('order_details');
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
        Schema::dropIfExists('order_additional_details');
    }
}
