<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Definirajte proizvode s pripadajućim SKU-ovima
        $products = [
            // Power Tools
            ['name' => 'Cordless Drill', 'price' => 120.00, 'category_id' => 1],
            ['name' => 'Hammer Drill', 'price' => 150.00, 'category_id' => 1],
            ['name' => 'Impact Wrench', 'price' => 180.00, 'category_id' => 1],

            // Hand Tools
            ['name' => 'Screwdriver Set', 'price' => 25.00, 'category_id' => 2],
            ['name' => 'Adjustable Wrench', 'price' => 30.00, 'category_id' => 2],
            ['name' => 'Hammer', 'price' => 40.00, 'category_id' => 2],

            // Garden Tools
            ['name' => 'Garden Shears', 'price' => 35.00, 'category_id' => 3],
            ['name' => 'Lawn Mower', 'price' => 220.00, 'category_id' => 3],
            ['name' => 'Rake', 'price' => 15.00, 'category_id' => 3],

            // Plumbing
            ['name' => 'Pipe Wrench', 'price' => 45.00, 'category_id' => 4],
            ['name' => 'Plumbing Tape', 'price' => 5.00, 'category_id' => 4],
            ['name' => 'Pipe Cutter', 'price' => 50.00, 'category_id' => 4],

            // Electrical
            ['name' => 'Wire Strippers', 'price' => 20.00, 'category_id' => 5],
            ['name' => 'Multimeter', 'price' => 70.00, 'category_id' => 5],
            ['name' => 'Extension Cord', 'price' => 25.00, 'category_id' => 5],

            // Building Materials
            ['name' => 'Drywall Sheet', 'price' => 12.00, 'category_id' => 6],
            ['name' => 'Cement Bag', 'price' => 10.00, 'category_id' => 6],
            ['name' => 'Concrete Mixer', 'price' => 300.00, 'category_id' => 6],

            // Hardware
            ['name' => 'Screws Assortment', 'price' => 10.00, 'category_id' => 7],
            ['name' => 'Nails Assortment', 'price' => 12.00, 'category_id' => 7],
            ['name' => 'Bolts and Nuts', 'price' => 15.00, 'category_id' => 7],

            // Safety Gear
            ['name' => 'Safety Goggles', 'price' => 20.00, 'category_id' => 8],
            ['name' => 'Protective Gloves', 'price' => 15.00, 'category_id' => 8],
            ['name' => 'Hard Hat', 'price' => 30.00, 'category_id' => 8],

            // Paints and Finishes
            ['name' => 'Interior Paint', 'price' => 25.00, 'category_id' => 9],
            ['name' => 'Exterior Paint', 'price' => 30.00, 'category_id' => 9],
            ['name' => 'Wood Stain', 'price' => 40.00, 'category_id' => 9],
        ];

        // Generiranje jedinstvenih SKU-ova za proizvode
        $existingSkus = DB::table('products')->pluck('sku')->toArray();
        $uniqueSkus = $existingSkus; // Počinjemo sa već postojećim SKU-ovima

        foreach ($products as &$product) {
            // Generiraj SKU kao prvi 3 slova naziva proizvoda + nasumični broj
            $baseSku = strtoupper(substr($product['name'], 0, 3));
            do {
                $sku = $baseSku . mt_rand(10000, 99999);  // Nasumični broj između 10000 i 99999
            } while (in_array($sku, $uniqueSkus));

            $product['sku'] = $sku;
            $uniqueSkus[] = $sku; // Dodaj SKU u listu da se osigura jedinstvenost
        }

        // var_dump($products);
        // Umetanje proizvoda u tablicu
        // foreach ($products as $product) {
        //     DB::table('products')->insert([
        //         'sku' => $product['sku'],
        //         'name' => $product['name'],
        //         'price' => $product['price'],
        //         'published' => true,
        //     ]);
        // }

        foreach ($products as $product) {
            // Provjeri postoji li već SKU u bazi podataka
            $existingProduct = DB::table('products')->where('sku', $product['sku'])->first();

            if ($existingProduct) {
                // Ako SKU već postoji, preskoči umetanje ovog proizvoda
                continue;
            }

            // Sada umetni proizvod s jedinstvenim SKU-om
            DB::table('products')->insert([
                'sku' => $product['sku'],
                'name' => $product['name'],
                'price' => $product['price'],
                'published' => true,
            ]);
        }

        // Povezivanje proizvoda s kategorijama
        // Prvo, dohvati id-ove proizvoda
        $productSkus = DB::table('products')->pluck('id', 'sku')->toArray();

        // Definirajte poveznice između proizvoda i kategorija
        // $productCategories = [
        //     ['sku' => $uniqueSkus[0], 'category_id' => 1], // Poveži Cordless Drill s Power Tools
        //     ['sku' => $uniqueSkus[1], 'category_id' => 1], // Poveži Hammer Drill s Power Tools
        //     ['sku' => $uniqueSkus[2], 'category_id' => 1], // Poveži Impact Wrench s Power Tools
        //     ['sku' => $uniqueSkus[3], 'category_id' => 2], // Poveži Screwdriver Set s Hand Tools
        //     ['sku' => $uniqueSkus[4], 'category_id' => 2], // Poveži Adjustable Wrench s Hand Tools
        //     ['sku' => $uniqueSkus[5], 'category_id' => 2], // Poveži Hammer s Hand Tools
        //     ['sku' => $uniqueSkus[6], 'category_id' => 3], // Poveži Garden Shears s Garden Tools
        //     ['sku' => $uniqueSkus[7], 'category_id' => 3], // Poveži Lawn Mower s Garden Tools
        //     ['sku' => $uniqueSkus[8], 'category_id' => 3], // Poveži Rake s Garden Tools
        //     ['sku' => $uniqueSkus[9], 'category_id' => 4], // Poveži Pipe Wrench s Plumbing
        //     ['sku' => $uniqueSkus[10], 'category_id' => 4], // Poveži Plumbing Tape s Plumbing
        //     ['sku' => $uniqueSkus[11], 'category_id' => 4], // Poveži Pipe Cutter s Plumbing
        //     ['sku' => $uniqueSkus[12], 'category_id' => 5], // Poveži Wire Strippers s Electrical
        //     ['sku' => $uniqueSkus[13], 'category_id' => 5], // Poveži Multimeter s Electrical
        //     ['sku' => $uniqueSkus[14], 'category_id' => 5], // Poveži Extension Cord s Electrical
        //     ['sku' => $uniqueSkus[15], 'category_id' => 6], // Poveži Drywall Sheet s Building Materials
        //     ['sku' => $uniqueSkus[16], 'category_id' => 6], // Poveži Cement Bag s Building Materials
        //     ['sku' => $uniqueSkus[17], 'category_id' => 6], // Poveži Concrete Mixer s Building Materials
        //     ['sku' => $uniqueSkus[18], 'category_id' => 7], // Poveži Screws Assortment s Hardware
        //     ['sku' => $uniqueSkus[19], 'category_id' => 7], // Poveži Nails Assortment s Hardware
        //     ['sku' => $uniqueSkus[20], 'category_id' => 7], // Poveži Bolts and Nuts s Hardware
        //     ['sku' => $uniqueSkus[21], 'category_id' => 8], // Poveži Safety Goggles s Safety Gear
        //     ['sku' => $uniqueSkus[22], 'category_id' => 8], // Poveži Protective Gloves s Safety Gear
        //     ['sku' => $uniqueSkus[23], 'category_id' => 8], // Poveži Hard Hat s Safety Gear
        //     ['sku' => $uniqueSkus[24], 'category_id' => 9], // Poveži Interior Paint s Paints and Finishes
        //     ['sku' => $uniqueSkus[25], 'category_id' => 9], // Poveži Exterior Paint s Paints and Finishes
        //     ['sku' => $uniqueSkus[26], 'category_id' => 9], // Poveži Wood Stain s Paints and Finishes
        // ];

        // Dohvati ID-ove kategorija
        $categories = DB::table('categories')->pluck('id', 'name')->toArray();

        // Definirajte poveznice između proizvoda i kategorija
        $productCategories = [
            ['sku' => $uniqueSkus[0], 'category_id' => $categories['Power Tools'] ?? 1],
            ['sku' => $uniqueSkus[1], 'category_id' => $categories['Power Tools'] ?? 1],
            ['sku' => $uniqueSkus[2], 'category_id' => $categories['Power Tools'] ?? 1],
            ['sku' => $uniqueSkus[3], 'category_id' => $categories['Hand Tools'] ?? 2],
            ['sku' => $uniqueSkus[4], 'category_id' => $categories['Hand Tools'] ?? 2],
            ['sku' => $uniqueSkus[5], 'category_id' => $categories['Hand Tools'] ?? 2],
            ['sku' => $uniqueSkus[6], 'category_id' => $categories['Garden Tools'] ?? 3],
            ['sku' => $uniqueSkus[7], 'category_id' => $categories['Garden Tools'] ?? 3],
            ['sku' => $uniqueSkus[8], 'category_id' => $categories['Garden Tools'] ?? 3],
            ['sku' => $uniqueSkus[9], 'category_id' => $categories['Plumbing'] ?? 4],
            ['sku' => $uniqueSkus[10], 'category_id' => $categories['Plumbing'] ?? 4],
            ['sku' => $uniqueSkus[11], 'category_id' => $categories['Plumbing'] ?? 4],
            ['sku' => $uniqueSkus[12], 'category_id' => $categories['Electrical'] ?? 5],
            ['sku' => $uniqueSkus[13], 'category_id' => $categories['Electrical'] ?? 5],
            ['sku' => $uniqueSkus[14], 'category_id' => $categories['Electrical'] ?? 5],
            ['sku' => $uniqueSkus[15], 'category_id' => $categories['Building Materials'] ?? 6],
            ['sku' => $uniqueSkus[16], 'category_id' => $categories['Building Materials'] ?? 6],
            ['sku' => $uniqueSkus[17], 'category_id' => $categories['Building Materials'] ?? 6],
            ['sku' => $uniqueSkus[18], 'category_id' => $categories['Hardware'] ?? 7],
            ['sku' => $uniqueSkus[19], 'category_id' => $categories['Hardware'] ?? 7],
            ['sku' => $uniqueSkus[20], 'category_id' => $categories['Hardware'] ?? 7],
            ['sku' => $uniqueSkus[21], 'category_id' => $categories['Safety Gear'] ?? 8],
            ['sku' => $uniqueSkus[22], 'category_id' => $categories['Safety Gear'] ?? 8],
            ['sku' => $uniqueSkus[23], 'category_id' => $categories['Safety Gear'] ?? 8],
            ['sku' => $uniqueSkus[24], 'category_id' => $categories['Paints and Finishes'] ?? 9],
            ['sku' => $uniqueSkus[25], 'category_id' => $categories['Paints and Finishes'] ?? 9],
            ['sku' => $uniqueSkus[26], 'category_id' => $categories['Paints and Finishes'] ?? 9],
        ];
        // Umetanje poveznica između proizvoda i kategorija
        // foreach ($productCategories as $productCategory) {
        //     DB::table('product_category')->insert([
        //         'product_id' => $productSkus[$productCategory['sku']],
        //         'category_id' => $productCategory['category_id'],
        //     ]);
        // }

        foreach ($productCategories as $productCategory) {
            // Dohvatite ID proizvoda prema SKU
            $productExists = DB::table('products')->where('sku', $productCategory['sku'])->exists();

            if ($productExists) {
                // Dohvati ID proizvoda prema SKU
                $productSKU = DB::table('products')->where('sku', $productCategory['sku'])->value('sku');
                // var_dump($productSKU);
                // Umetnite u product_category
                DB::table('product_category')->insert([
                    'product_id' => $productSKU,
                    'category_id' => $productCategory['category_id'],
                ]);
            } else {
                // Možete dodati logiku za slučaj kada SKU ne postoji
                // Log::error("Product SKU not found: " . $productCategory['sku']);
            }
        }
    }
}
