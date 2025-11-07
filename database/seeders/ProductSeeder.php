<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
        [
            'name' => 'Vitamin Tablets',
            'stock' => 100,
            'price' => 50.00,
        ],
        [
            'name' => 'Protein Power Shake',
            'stock' => 80,
            'price' => 75.00,
        ],
        [
            'name' => 'Omega-3 Fish Oil',
            'stock' => 120,
            'price' => 60.00,
        ],
        [
            'name' => 'Herbal Energy Booster',
            'stock' => 50,
            'price' => 90.00,
        ],
        [
            'name' => 'Immunity Plus Tablets',
            'stock' => 200,
            'price' => 45.00,
        ],
    ]);

    }
}
