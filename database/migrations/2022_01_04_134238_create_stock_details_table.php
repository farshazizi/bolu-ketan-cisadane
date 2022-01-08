<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stock_id')->index();
            $table->uuid('inventory_stock_id')->index();
            $table->integer('quantity');
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('inventory_stock_id')->references('id')->on('inventory_stocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_details');
    }
}
