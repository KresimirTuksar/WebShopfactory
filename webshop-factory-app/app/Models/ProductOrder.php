<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'product_sku', 'quantity', 'unit_price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_sku', 'sku');
    }
}
