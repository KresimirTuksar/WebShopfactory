<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractlistsTable extends Migration
{
    public function up()
    {
        Schema::create('contractlists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('product_sku');
            $table->decimal('price', 10, 2);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_sku')->references('sku')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contractlists');
    }
}
