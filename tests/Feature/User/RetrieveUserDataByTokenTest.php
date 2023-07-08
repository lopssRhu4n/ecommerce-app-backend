<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrieveUserDataByTokenTest extends TestCase
{
    /** @test */
    public function it_should_be_possible_to_retrieve_data_by_token()
    {
        // arrange
        $user = User::factory()->createOne();

        $user->client()->create(['cpf' => 11111111111, 'phone' => 99999999999, 'birthdate' => '01-01-2000'])->cart->products;
        // act

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $user->createToken('auth')->plainTextToken])->getJson('/api/user');
        // assert

        $user->client->cart->products;
        $response->assertStatus(200);
        $response->assertSimilarJson($user->toArray());
    }
}
