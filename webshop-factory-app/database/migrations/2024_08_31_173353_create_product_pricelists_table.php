<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricelistsTable extends Migration
{
    public function up()
    {
        Schema::create('product_pricelist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_sku');
            $table->unsignedBigInteger('pricelist_id');
            $table->decimal('price', 10, 2);

            $table->foreign('product_sku')->references('sku')->on('products')->onDelete('cascade');
            $table->foreign('pricelist_id')->references('id')->on('pricelists')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_pricelist');
    }
}
