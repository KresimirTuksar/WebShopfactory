<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Exception;

use App\Services\PriceService;

class ProductController extends Controller
{
    private $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

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
                // Postavi cijenu
                $price = $this->priceService->getProductPrice($product, $user);
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
