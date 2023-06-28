<?php

namespace Tests\Feature\Cart;

use App\Models\Client;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function it_should_be_possible_to_add_product_to_a_cart()
    {
        $this->seed();

        $response = $this->postJson('/api/cart/', [ "client_id" => 1]);


        $response->assertStatus(201);
    }
}
