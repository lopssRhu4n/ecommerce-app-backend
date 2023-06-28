<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProductToCartTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_add_product_to_a_car()
    {
        $this->seed();



        $data =  ["cart_id" => 1, "product_id" => 2];

        $response = $this->postJson('/api/cart/product', $data);

        $cart = Cart::query()->find(1);

        $totalAmount =  0;

        foreach ($cart->products as $product) {
            $totalAmount += $product->price;
        }

        $response->assertStatus(201);
        $response->assertJsonPath("cart.amount", $totalAmount);
    }
}
