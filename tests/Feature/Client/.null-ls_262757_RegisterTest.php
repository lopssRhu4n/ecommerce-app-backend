<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    /** @test */
    public function it_should_be_able_to_register_as_a_new_client()
    {
        // Arrange

        $clientData = Client::factory(1)->makeOne()->toArray();

        //Act
        $response = $this->postJson(
            '/api/client/register',
            $clientData
        );

        //Assert
        $response
            ->assertJsonPath('client.cart' => [
                "client_id" => 1,
                "amount" => 0,
                "discount" => 0,
                "shipping" => 0
            ]
)
            ->assertStatus(201);


        $this->assertDatabaseHas(
            'clients',
            $clientData
        );

        $this->assertDatabaseHas(
            'carts',
            [
                "client_id" => 1,
                "amount" => 0,
                "discount" => 0,
                "shipping" => 0
            ]
        );
    }

    /** @test */
    public function name_should_be_required()
    {
        $this->postJson('/api/client/register', [])
            ->assertStatus(400)
            ->assertJsonFragment(['name' => ["The name field is required."]]);
    }

    /** @test */
    public function email_should_be_required()
    {
        $this->postJson('/api/client/register', ['name' => 'test'])
            ->assertStatus(400)
            ->assertJsonFragment(['email' => ["The email field is required."]]);
    }

    /** @test */
    public function email_should_be_unique()
    {
        Client::factory()->create(["email" => "test@gmail.com"]);
        $this->postJson('/api/client/register', ["email" => "test@gmail.com"])
            ->assertStatus(400)
            ->assertJsonFragment(['email' => ['The email has already been taken.']]);
    }

    /** @test */
    public function email_should_be_valid_email()
    {
        $this->postJson('/api/client/register', ["email" => "1123_@a@.com.b"])
            ->assertStatus(400)
            ->assertJsonFragment(['email' => ['The email field must be a valid email address.']]);
    }

    /** @test */
    public function cpf_should_be_required()
    {
        $this->postJson('/api/client/register', [])->assertStatus(400)->assertJsonFragment(['cpf' => ["The cpf field is required."]]);
    }

    /** @test */
    public function cpf_should_be_unique()
    {

        Client::factory()->create(['cpf' => 98765432111]);
        $this->postJson('/api/client/register', ['cpf' => 98765432111])
            ->assertStatus(400)
            ->assertJsonFragment(["cpf" => ["CPF already registered."]]);
    }

    /** @test */
    public function birthdate_should_be_required()
    {
        $this->postJson('/api/client/register', [])->assertStatus(400)->assertJsonFragment(['birthdate' => ["The birthdate field is required."]]);
    }

    /** @test */
    public function phone_should_be_required()
    {
        $this->postJson('/api/client/register', [])->assertStatus(400)->assertJsonFragment(['phone' => ["The phone field is required."]]);
    }
}
