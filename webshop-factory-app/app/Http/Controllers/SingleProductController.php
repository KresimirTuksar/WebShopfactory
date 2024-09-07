<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function show(Request $request, $product_sku)
    {
        $user_id = $request->input('user_id', null);

        // Error handling: provjera postoji li user
        $user = User::find($user_id);

        // Ako je user_id dan, ali korisnik nije pronađen
        if ($user_id && !$user) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }

        // Dohvati proizvod prema SKU
        $product = Product::where('sku', $product_sku)->first();


        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Određivanje cijene
        $price = $product->price; // Zadana cijena proizvoda

        if ($user) {

            // Provjeri postoji li ugovoreni popust za korisnika
            $contract = $product->contractlists()->where('user_id', $user->id)->first();
            if ($contract) {
                $price = $contract->price;
            } else {
                // Ako nema ugovora, provjeri ima li korisnik dodijeljen cjenik
                $pricelist = $user->pricelist;

                if ($pricelist) {
                    $pricelistProduct = $product->pricelists()->where('pricelist_id', $pricelist->id)->first();
                    if ($pricelistProduct) {
                        $price = $pricelistProduct->pivot->price;
                    }
                }
            }
        }

        $product->price = $price;

        return response()->json($product);
    }
}
