<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->unique();
            $table->string('name')->unique();
            $table->decimal('price', 10, 2);
            $table->boolean('published');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}

