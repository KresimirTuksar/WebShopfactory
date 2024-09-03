<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceListSeeder extends Seeder
{
    public function run()
    {
        // Definirajte tipove kupaca kao imena cjenika
        $priceLists = [
            'Retail',
            'Wholesale',
            'Distributor',
            'Reseller',
            // Dodajte ostale tipove prema potrebi
        ];

        // Umetanje tipova kupaca kao imena cjenika u tablicu
        foreach ($priceLists as $name) {
            DB::table('pricelists')->insert([
                'name' => $name,
            ]);
        }

        // Dohvati sve SKU-ove proizvoda i cjenike
        $products = DB::table('products')->pluck('sku')->toArray();
        $pricelists = DB::table('pricelists')->pluck('id')->toArray();

        // Ako nemamo proizvode ili cjenike, izađi
        // if (empty($products) || empty($pricelists)) {
        //     Log::info('No products or pricelists to seed.');
        //     return;
        // }

        // Definiraj koliko unosimo poveznica
        $numEntries = 20; // Broj poveznica za unos

        for ($i = 0; $i < $numEntries; $i++) {
            DB::table('product_pricelist')->insert([
                'product_sku' => $products[array_rand($products)], // Nasumično odabran SKU
                'pricelist_id' => $pricelists[array_rand($pricelists)], // Nasumično odabran cjenik
                'price' => rand(10, 500), // Nasumična cijena

            ]);
        }
    }
}
