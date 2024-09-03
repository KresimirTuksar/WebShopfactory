<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContractListSeeder extends Seeder
{
    public function run()
    {
        // Dohvati nasumična 2 korisnika
        $userIds = DB::table('users')->pluck('id')->shuffle()->take(2)->toArray();



        // Dohvati sve proizvode
        $products = DB::table('products')->pluck('sku')->toArray();

        // Ako nema proizvoda, izađi
        if (empty($products)) {
            Log::warning('Nema proizvoda za kreiranje ugovora.');
            return;
        }

        // Generiraj nasumične cijene za proizvode
        $contractList = [];
        foreach ($userIds as $userId) {
            foreach (array_rand($products, 2) as $productKey) { // Odaberi 2 nasumična proizvoda za svakog korisnika
                $contractList[] = [
                    'user_id' => $userId,
                    'product_sku' => $products[$productKey],
                    'price' => rand(10, 1000), // Nasumična cijena između 10 i 1000
                ];
            }
        }

        // Umetanje podataka u tablicu
        DB::table('contractlists')->insert($contractList);
    }
}
