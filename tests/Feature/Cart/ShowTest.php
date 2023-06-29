<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\Client;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function it_should_be_possible_to_retrieve_single_cart_information()
    {
        Client::factory()->createOne();
        $cart = Cart::factory()->create([ 'client_id' => 1]);


        $response = $this->getJson('/api/cart/1');

        $response->assertStatus(200);
        $response->assertJson( function (AssertableJson $json) use ($cart) {
            $json->whereAll($cart->toArray());
        });

    }
}
