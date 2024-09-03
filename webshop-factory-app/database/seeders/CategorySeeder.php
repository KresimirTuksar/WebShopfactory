<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Definirajte kategorije
        $categories = [
            ['name' => 'Power Tools', 'description' => 'Electric and battery-powered tools for various applications.'],
            ['name' => 'Hand Tools', 'description' => 'Manual tools for construction, repair, and maintenance.'],
            ['name' => 'Garden Tools', 'description' => 'Tools for gardening and outdoor maintenance.'],
            ['name' => 'Plumbing', 'description' => 'Plumbing supplies and tools for installations and repairs.'],
            ['name' => 'Electrical', 'description' => 'Electrical components and tools for wiring and repairs.'],
            ['name' => 'Building Materials', 'description' => 'Materials used in construction and renovation projects.'],
            ['name' => 'Hardware', 'description' => 'Various hardware items such as screws, nails, and bolts.'],
            ['name' => 'Safety Gear', 'description' => 'Protective equipment for safety and health during work.'],
            ['name' => 'Paints and Finishes', 'description' => 'Products for painting and finishing surfaces.'],
        ];

        // Umetanje u tablicu
        DB::table('categories')->insert($categories);
    }
}
