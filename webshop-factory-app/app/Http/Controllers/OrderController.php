<?php

// namespace App\Http\Controllers;

// use App\Models\Order;
// use App\Models\ProductOrder;
// use App\Models\OrderMeta;
// use App\Models\Product;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;
// use Exception;

// class OrderController extends Controller
// {
//     public function store(Request $request)
//     {
//         // Validacija ulaznih podataka
//         $validated = $request->validate([
//             'user_id' => 'required|exists:users,id',
//             'products' => 'required|array',
//             'products.*.sku' => 'required|exists:products,sku',
//             'products.*.quantity' => 'required|integer|min:1',
//         ]);

//         Log::info('Validation successful');
//         DB::beginTransaction();

//         try {
//             // Dohvati korisnika
//             $user = User::findOrFail($request['user_id']);

//             // Početne vrijednosti
//             $subtotal = 0;
//             $taxRate = 0.25; // 25% poreza
//             $discountAmount = 0; // Početni popust
//             $discountRate = 0;   // Stopa popusta

//             // Kreiraj narudžbu
//             $order = new Order();
//             $order->user_id = $user->id;
//             $order->subtotal = 0;
//             $order->tax_amount = 0;
//             $order->discount_amount = 0;
//             $order->total_amount = 0;
//             $order->save();

//             // Pohrana podataka o korisniku u order_meta
//             $this->saveOrderMeta($order->id, 'customer_name', $user->name);
//             $this->saveOrderMeta($order->id, 'customer_email', $user->email);
//             $this->saveOrderMeta($order->id, 'customer_phone', $user->phone);
//             $this->saveOrderMeta($order->id, 'customer_address', $user->address);
//             $this->saveOrderMeta($order->id, 'customer_city', $user->city);
//             $this->saveOrderMeta($order->id, 'customer_country', $user->country);

//             // Iteriraj kroz proizvode i dodaj ih u narudžbu
//             foreach ($validated['products'] as $productData) {
//                 $product = Product::where('sku', $productData['sku'])->firstOrFail();
//                 $quantity = $productData['quantity'];
//                 $unitPrice = $product->price; // Default cijena

//                 // Provjera contract i pricelist cijena
//                 $contract = $product->contractlists()->where('user_id', $user->id)->first();
//                 if ($contract) {
//                     $unitPrice = $contract->price;
//                 } else {
//                     $pricelistProduct = $product->pricelists()->where('pricelist_id', $user->pricelist_id)->first();
//                     if ($pricelistProduct) {
//                         $unitPrice = $pricelistProduct->pivot->price;
//                     }
//                 }

//                 // Ukupna cijena za proizvod
//                 $totalPriceForProduct = $unitPrice * $quantity;

//                 // Kreiraj stavku narudžbe
//                 $productOrder = new ProductOrder();
//                 $productOrder->order_id = $order->id;
//                 $productOrder->product_sku = $product->sku;
//                 $productOrder->quantity = $quantity;
//                 $productOrder->unit_price = $unitPrice;
//                 $productOrder->save();

//                 // Ažuriraj međuzbroj
//                 $subtotal += $totalPriceForProduct;
//             }

//             // Porez
//             $taxAmount = $subtotal * $taxRate;

//             // Popust: ako ukupna cijena prelazi 100 eura, dodaj 10% popusta
//             if ($subtotal > 100) {
//                 $discountRate = 0.10; // 10%
//                 $discountAmount = $subtotal * $discountRate;
//             } else {
//                 $discountAmount = 0;
//             }

//             // Konačna ukupna cijena
//             $totalAmount = $subtotal + $taxAmount - $discountAmount;

//             // Ažuriranje narudžbe s konačnim iznosima
//             $order->subtotal = $subtotal;
//             $order->tax_amount = $taxAmount;
//             $order->discount_amount = $discountAmount;
//             $order->total_amount = $totalAmount;
//             $order->save();

//             DB::commit();

//             return response()->json([
//                 'message' => 'Narudžba uspješno kreirana',
//                 'order_id' => $order->id,
//                 'subtotal' => $subtotal,
//                 'tax_amount' => $taxAmount,
//                 'discount_amount' => $discountAmount,
//                 'total_amount' => $totalAmount,
//             ], 201);

//         } catch (Exception $e) {
//             DB::rollBack();

//             return response()->json([
//                 'message' => 'Greška prilikom kreiranja narudžbe',
//                 'error' => $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Spremi meta podatke za narudžbu
//      */
//     private function saveOrderMeta($orderId, $metaKey, $metaValue)
//     {
//         OrderMeta::create([
//             'order_id' => $orderId,
//             'meta_key' => $metaKey,
//             'meta_value' => $metaValue,
//         ]);
//     }
// }



namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\OrderMeta;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Napravi validator za validaciju ulaznih podataka
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.sku' => 'required|exists:products,sku',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Ako validacija ne uspije, vrati JSON odgovor s greškom
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Greška u validaciji podataka',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }

        $validated = $validator->validated(); // Dohvati validirane podatke

        // Log::info('Validation successful');
        DB::beginTransaction();

        try {
            // Dohvati korisnika
            $user = User::findOrFail($validated['user_id']);

            // Početne vrijednosti
            $subtotal = 0;
            $taxRate = 0.25; // 25% poreza
            $discountAmount = 0; // Početni popust
            $discountRate = 0;   // Stopa popusta

            // Kreiraj narudžbu
            $order = new Order();
            $order->user_id = $user->id;
            $order->subtotal = 0;
            $order->tax_amount = 0;
            $order->discount_amount = 0;
            $order->total_amount = 0;
            $order->save();

            // Pohrana podataka o korisniku u order_meta
            $this->saveOrderMeta($order->id, 'customer_name', $user->name);
            $this->saveOrderMeta($order->id, 'customer_email', $user->email);
            $this->saveOrderMeta($order->id, 'customer_phone', $user->phone);
            $this->saveOrderMeta($order->id, 'customer_address', $user->address);
            $this->saveOrderMeta($order->id, 'customer_city', $user->city);
            $this->saveOrderMeta($order->id, 'customer_country', $user->country);

            // Iteriraj kroz proizvode i dodaj ih u narudžbu
            foreach ($validated['products'] as $productData) {
                $product = Product::where('sku', $productData['sku'])->firstOrFail();
                $quantity = $productData['quantity'];
                $unitPrice = $product->price; // Default cijena

                // Provjera contract i pricelist cijena
                $contract = $product->contractlists()->where('user_id', $user->id)->first();
                if ($contract) {
                    $unitPrice = $contract->price;
                } else {
                    $pricelistProduct = $product->pricelists()->where('pricelist_id', $user->pricelist_id)->first();
                    if ($pricelistProduct) {
                        $unitPrice = $pricelistProduct->pivot->price;
                    }
                }

                // Ukupna cijena za proizvod
                $totalPriceForProduct = $unitPrice * $quantity;

                // Kreiraj stavku narudžbe
                $productOrder = new ProductOrder();
                $productOrder->order_id = $order->id;
                $productOrder->product_sku = $product->sku;
                $productOrder->quantity = $quantity;
                $productOrder->unit_price = $unitPrice;
                $productOrder->save();

                // Ažuriraj međuzbroj
                $subtotal += $totalPriceForProduct;
            }

            // Porez
            $taxAmount = $subtotal * $taxRate;

            // Popust: ako ukupna cijena prelazi 100 eura, dodaj 10% popusta
            if ($subtotal > 100) {
                $discountRate = 0.10; // 10%
                $discountAmount = $subtotal * $discountRate;
            } else {
                $discountAmount = 0;
            }

            // Konačna ukupna cijena
            $totalAmount = $subtotal + $taxAmount - $discountAmount;

            // Ažuriranje narudžbe s konačnim iznosima
            $order->subtotal = $subtotal;
            $order->tax_amount = $taxAmount;
            $order->discount_amount = $discountAmount;
            $order->total_amount = $totalAmount;
            $order->save();

            DB::commit();

            return response()->json([
                'message' => 'Narudžba uspješno kreirana',
                'order_id' => $order->id,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Greška prilikom kreiranja narudžbe',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Spremi meta podatke za narudžbu
     */
    private function saveOrderMeta($orderId, $metaKey, $metaValue)
    {
        OrderMeta::create([
            'order_id' => $orderId,
            'meta_key' => $metaKey,
            'meta_value' => $metaValue,
        ]);
    }
}
