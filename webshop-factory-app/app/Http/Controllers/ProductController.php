<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPricelist;
use App\Models\Contractlist;
use App\Models\User;
use Exception;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user_id = $request->input('user_id', null);
            // Pokušaj dohvatiti korisnika ako postoji user_id
            $user = $user_id ? User::find($user_id) : null;

            // Ako je user_id dan, ali korisnik nije pronađen
            if ($user_id && !$user) {
                return response()->json([
                    'error' => 'User not found'
                ], 404);
            }

            // Dohvati veličinu stranice iz zahtjeva ili postavi na 10
            $pageSize = $request->input('page_size', 10);
            // Dohvati proizvode s paginacijom
            $products = Product::paginate($pageSize);

            // Inicijaliziraj prazan niz za JSON odgovor
            $productList = [];

            foreach ($products as $product) {
                // Postavi osnovnu cijenu (cijena iz products tablice)
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

                // Dodaj proizvod i cijenu u listu za JSON odgovor
                $productList[] = [
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'price' => $price,
                ];
            }

            // Vrati JSON odgovor s paginacijom
            return response()->json([
                'data' => $productList,
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'next_page_url' => $products->nextPageUrl(),
                    'prev_page_url' => $products->previousPageUrl(),
                ]
            ], 200);

        } catch (Exception $e) {
            // Vraća JSON odgovor s porukom o grešci
            return response()->json([
                'error' => 'An error occurred while retrieving the products.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
