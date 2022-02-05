<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_id')->index();
            $table->uuid('ingredient_id')->index();
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('total');
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
}
