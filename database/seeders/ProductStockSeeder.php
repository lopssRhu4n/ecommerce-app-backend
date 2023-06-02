<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ProductStock::factory(10)->create();
    }
}
