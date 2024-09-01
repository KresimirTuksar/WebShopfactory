<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['sku', 'name', 'price', 'published'];

    protected $primaryKey = 'sku';
    public $incrementing = false;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id', 'sku', 'id');
    }

    public function pricelists()
    {
        return $this->belongsToMany(Pricelist::class, 'product_pricelist', 'product_sku', 'pricelist_id')
            ->withPivot('price');
    }

    public function contractlists()
    {
        return $this->hasMany(Contractlist::class, 'product_sku', 'sku');
    }
}
