<?php

namespace Tests\Feature\User;

use App\Models\Cart;
use App\Models\Client;
use App\Models\User;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function it_should_be_possible_to_retrieve_client_user_info_when_authentitated()
    {

        $clientData = Client::factory()->makeOne()->toArray();
        $cartData = Cart::factory()->makeOne()->toArray();

        $user = User::factory()->createOne();

        $client = $user->client()->create($clientData);

        $client->cart()->create($cartData);

        $token = $user->createToken('auth')->plainTextToken;

        // act

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->getJson("/api/user/$user->id"  );

        // assert

        $user->client->cart->products;

        $response->assertStatus(200);
        $response->assertSimilarJson(
            $user->toArray()
        );
    }

    /** @test */
    public function it_should_not_be_possible_to_retrieve_client_user_info_when_unauthentitated()
    {

        $clientData = Client::factory()->makeOne()->toArray();
        $cartData = Cart::factory()->makeOne()->toArray();

        $user = User::factory()->createOne();

        $client = $user->client()->create($clientData);
        $client->cart()->create($cartData);


        // act

        $response = $this->getJson("/api/user/$user->id"  );

        // assert

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_should_not_be_possible_to_retrieve_data_of_another_user()
    {
        // arrange

        $clientData = Client::factory()->makeOne()->toArray();
        $cartData = Cart::factory()->makeOne()->toArray();

        $user = User::factory()->createOne();

        User::factory()->createOne();

        $client = $user->client()->create($clientData);

        $client->cart()->create($cartData);

        $token = $user->createToken('auth')->plainTextToken;

        // act
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->getJson("/api/user/"  . $user->id + 1 );


        // assert

        $response->assertForbidden();
        $response->assertSimilarJson(['message' => 'Unauthorized.']);
    }

}
