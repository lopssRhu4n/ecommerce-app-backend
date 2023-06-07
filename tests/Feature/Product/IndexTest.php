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
        $this->seed();
        $products_quantity = Product::all()->count();
        $products = Product::all()->all();

        // act

        $this->get('/api/product/')
            ->assertStatus(200)
            ->assertJsonFragment([
            "quantity" => $products_quantity,
        ]);
    }
}
