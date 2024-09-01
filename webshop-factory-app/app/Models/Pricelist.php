<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_pricelist', 'pricelist_id', 'product_sku')
            ->withPivot('price');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'pricelist_id');
    }
}
