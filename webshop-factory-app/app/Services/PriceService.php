<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductPricelist;
use App\Models\Contractlist;
use App\Models\User;

class PriceService
{
    public function getProductPrice(Product $product, ?User $user = null): float
    {
        $price = $product->price;

        if ($user) {
            // Provjeri postoji li ugovor za korisnika i proizvod
            $contract = Contractlist::where('user_id', $user->id)
                ->where('product_sku', $product->sku)
                ->first();

            if ($contract) {
                // Ako postoji ugovor, koristi cijenu iz ugovora
                $price = $contract->price;
            } else {
                // Ako nema ugovora, provjeri postoji li cjenik povezan s korisnikom
                $productPricelist = ProductPricelist::where('product_sku', $product->sku)
                    ->where('pricelist_id', $user->pricelist_id)
                    ->first();

                if ($productPricelist) {
                    // Ako postoji cjenik, koristi cijenu iz cjenika
                    $price = $productPricelist->price;
                }
            }
        }

        return $price;
    }
}
