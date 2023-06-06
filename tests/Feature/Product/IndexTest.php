<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function it_should_list_all_of_the_created_products()
    {
        // arrange
        $products = Product::all();

        // act

        $this->post('/api/product')
            // assert
            ->assertStatus(200)
            ->assertJson($products);
    }
}
