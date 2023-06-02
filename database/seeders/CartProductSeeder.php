<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CartProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CartProduct::factory(10)->create();
    }
}
