<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function it_should_show_only_the_requested_product()
    {
        // arrange
        $this->seed();
        $id = 5;
        $product = Product::query()->find($id);


        // act

        $response = $this->getJson("/api/product/$id");

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($product) {
            $json->hasAll([
                'id',
                'name',
                'description',
                'price',
                'category_id',
                'sales',
                'likes',
                'image',
                'created_at',
                'updated_at'
            ]);

            $json->whereAll([
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'sales' => $product->sales,
                'likes' => $product->likes,
                'image' => $product->image
            ]);
        });

        // assert
    }
}
