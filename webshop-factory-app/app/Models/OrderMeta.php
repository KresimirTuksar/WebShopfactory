<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
    public $timestamps = false;
    protected $table = 'order_meta';
    protected $fillable = ['order_id', 'meta_key', 'meta_value'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
