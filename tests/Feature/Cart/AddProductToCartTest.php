<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AddProductToCartTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_add_product_to_a_car_when_logged()
    {
        $this->seed();

        $cart = Cart::query()->find(1);
        $cart->client;

        $user_id = DB::query()->select('id')->from('users')->where('id', $cart->client->user_id)->first()->id;


        $token = User::query()->find($user_id)->createToken('auth')->plainTextToken;

        $data =  ["cart_id" => $cart->id, "product_id" => 2];

        $response = $this
            ->withHeaders([
            'Authorization' => "Bearer $token"
            ])
            ->postJson('/api/cart/product', $data);

        $cart = Cart::query()->find(1);

        $totalAmount =  0;

        foreach ($cart->products as $product) {
            $totalAmount += $product->price;
        }

        $response->assertStatus(201);
        $response->assertJsonPath("cart.amount", $totalAmount);
    }


    /** @test */
    public function it_should_not_be_possible_to_add_product_to_cart_when_not_logged_in()
    {
        // arrange

        Cart::factory()->createOne();
        Product::factory()->createOne();

        // act

        $response = $this->postJson('/api/cart/product', ['cart_id' => 1, 'product_id' => 1]);

        // assert

        $response->assertUnauthorized();
    }

    /** @test */
    public function it_should_not_be_possible_to_add_product_to_other_user_cart()
    {
        // arrange

        $this->seed();
        $token = User::find(1)->createToken('auth')->plainTextToken;

        // act

        $response = $this
            ->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/cart/product', ['cart_id' => 2, 'product_id' => 1]);


        // assert

        $response->assertForbidden();
    }
}
