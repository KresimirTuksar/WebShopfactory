<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Dohvati sve ID-ove iz pricelists tablice
        $pricelists = DB::table('pricelists')->pluck('id')->toArray();

        // Ako nema cjenika, izađi
        if (empty($pricelists)) {
            return;
        }

        // Definirajte korisnike
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'), // Koristi Hash za lozinku
                'pricelist_id' => $pricelists[0], // Dodaj prvi pricelist_id
                'phone' => '123-456-7890',
                'address' => '123 Main St',
                'city' => 'Springfield',
                'country' => 'USA',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123'),
                'pricelist_id' => $pricelists[1], // Dodaj drugi pricelist_id
                'phone' => '234-567-8901',
                'address' => '456 Elm St',
                'city' => 'Shelbyville',
                'country' => 'USA',
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'password' => Hash::make('password123'),
                'pricelist_id' => $pricelists[2], // Dodaj treći pricelist_id
                'phone' => '345-678-9012',
                'address' => '789 Oak St',
                'city' => 'Capital City',
                'country' => 'USA',
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'password' => Hash::make('password123'),
                'pricelist_id' => null, // Nema pricelist_id
                'phone' => '456-789-0123',
                'address' => '321 Pine St',
                'city' => 'Metropolis',
                'country' => 'USA',
            ],
            [
                'name' => 'Charlie Green',
                'email' => 'charlie.green@example.com',
                'password' => Hash::make('password123'),
                'pricelist_id' => null, // Nema pricelist_id
                'phone' => '567-890-1234',
                'address' => '654 Maple St',
                'city' => 'Gotham',
                'country' => 'USA',
            ],
        ];

        // Umetanje korisnika u tablicu
        DB::table('users')->insert($users);
    }
}
