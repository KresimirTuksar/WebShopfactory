<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

use App\Services\PriceService;
class SingleProductController extends Controller
{
    private $priceService;
    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

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

        // Postavi cijenu
        $price = $this->priceService->getProductPrice($product, $user);


        $product->price = $price;

        return response()->json($product);
    }
}
