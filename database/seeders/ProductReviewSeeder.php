<?php

namespace Database\Seeders;

use App\Models\ProductReview;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = json_decode(Storage::get('reviews.json'));


        foreach($data as $item) {
            ProductReview::create([
                'title' => $item->title,
                'client_id' => $item->client_id,
                'rating' => $item->rating,
                'body' => $item->body,
                'likes' => $item->likes,
                'product_id' => $item->product_id
            ]);
        }
    }
}
