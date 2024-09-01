<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'subtotal', 'tax_amount', 'total_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function meta()
    {
        return $this->hasMany(OrderMeta::class);
    }
}
