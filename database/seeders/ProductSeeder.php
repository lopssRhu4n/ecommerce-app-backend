<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = json_decode(Storage::get('products.json'));

        foreach ($data as $item) {
            if(property_exists($item,'image')) {
                $image = $item->image;
            } else {
                $image = 'product/default.png';
            }
            Product::create(
                [
                    'name' => $item->name,
                    'description' => $item->description,
                    'price' => $item->price,
                    'category_id' => $item->category,
                    'likes' => $item->likes,
                    'sales' => $item->sales,
                    'image' => $image
                ]
            );
        }
        //
    }
}
