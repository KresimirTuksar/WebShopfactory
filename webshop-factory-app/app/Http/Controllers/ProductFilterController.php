<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductFilterController extends Controller
{
    public function filter(Request $request)
    {
        $query = Product::query();
        $user_id = $request->input('user_id', null);

        // Filtriranje po osnovnim kriterijima (prije provjere cijena)
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->input('category_id'));
            });
        }

        // Dohvaćanje proizvoda
        $products = $query->get()->map(function ($product) use ($user_id) {
            $price = $product->price;

            if ($user_id) {
                $user = User::find($user_id);

                if ($user) {
                    $contract = $product->contractlists()->where('user_id', $user->id)->first();
                    if ($contract) {
                        $price = $contract->price;
                    } else {
                        $pricelist = $user->pricelist;
                        if ($pricelist) {
                            $pricelistProduct = $product->pricelists()->where('pricelist_id', $pricelist->id)->first();
                            if ($pricelistProduct) {
                                $price = $pricelistProduct->pivot->price;
                            }
                        }
                    }
                }

            }

            return [
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->name,
                'price' => $price,
            ];
        });

        // Sortiranje nakon što su sve cijene obrađene
        if ($request->has('sort_price')) {
            $products = $products->sortBy('price', SORT_REGULAR, $request->input('sort_price') == 'desc');
        }

        if ($request->has('sort_name')) {
            $products = $products->sortBy('name', SORT_REGULAR, $request->input('sort_name') == 'desc');
        }

        // Filtriranje po cijeni nakon što su cijene obrađene
        if ($request->has('price_min')) {
            $products = $products->filter(function ($product) use ($request) {
                return $product['price'] >= $request->input('price_min');
            });
        }

        if ($request->has('price_max')) {
            $products = $products->filter(function ($product) use ($request) {
                return $product['price'] <= $request->input('price_max');
            });
        }

        return response()->json($products->values()->all());
    }
}
