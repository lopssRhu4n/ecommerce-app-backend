<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function it_should_list_all_of_the_created_products()
    {
        // arrange
        $this->seed();
        $products = Product::all();

        // act

        $response = $this->get('/api/product/');

        $response->assertStatus(200);
        $response->assertJsonCount($products->count());
        $response->assertJson(function (AssertableJson $json) use ($products) {
            $json->hasAll([
                '0.id',
                '0.name',
                '0.description',
                '0.category_id',
                '0.price',
                '0.likes',
                '0.sales',
                '0.image'
            ]);

            $product = $products->first();

            $json->whereAll([
                '0.id' => $product->id,
                '0.name' => $product->name,
                '0.description' => $product->description,
                '0.category_id' => $product->category_id,
                '0.price' => $product->price,
                '0.likes' => $product->likes,
                '0.sales' => $product->sales,
                '0.image' => $product->image,
            ]);
        });
    }
}
