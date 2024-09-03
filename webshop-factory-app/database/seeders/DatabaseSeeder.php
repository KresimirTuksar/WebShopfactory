<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Pozovi sve seedere
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            PricelistSeeder::class,
            UserSeeder::class,
            ContractListSeeder::class,
        ]);
    }
}
