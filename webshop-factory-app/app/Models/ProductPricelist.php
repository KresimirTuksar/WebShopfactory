<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPricelist extends Model
{
    protected $table = 'product_pricelist';
    protected $fillable = ['product_sku', 'pricelist_id', 'price'];

    public $timestamps = false;
}
