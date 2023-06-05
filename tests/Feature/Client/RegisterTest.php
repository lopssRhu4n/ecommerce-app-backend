<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    /** @test */
    public function it_should_be_able_to_register_as_a_new_client()
    {
        // test body
        // Arrange

        $name = fake()->name();
        $email = fake()->email();
        $cpf = fake()->numberBetween(10000000000, 99999999999);
        $birthdate = fake()->date();
        $phone = fake()->phoneNumber();

        //Act
        $response = $this->postJson('/api/register/client', [
            'name' => $name,
            'email' => $email,
            'cpf' => $cpf,
            'birthdate' => $birthdate,
            'phone' => $phone
        ]);


        //Assert
        $response
            ->assertStatus(201)
            ->assertJson([
                'created' => true
            ]);

        $this->assertDatabaseHas('clients', [
            'name' => $name,
            'email' => $email,
            'cpf' => $cpf,
            'birthdate' => $birthdate,
            'phone' => $phone

        ]);
    }

    /** @test */
    public function name_should_be_required()
    {
        $this->postJson('/api/register/client', [])
            ->assertStatus(400)
            ->assertJsonFragment(['name' => ["The name field is required."]]);
    }

    /** @test */
    public function email_should_be_required()
    {
        $this->postJson('/api/register/client', ['name' => 'test'])
            ->assertStatus(400)
            ->assertJsonFragment(['email' => ["The email field is required."]]);
    }

    /** @test */
    public function email_should_be_unique()
    {
        Client::factory()->create(["email" => "test@gmail.com"]);
        $this->postJson('/api/register/client', ["email" => "test@gmail.com"])
            ->assertStatus(400)
            ->assertJsonFragment(['email' => ['The email has already been taken.']]);
    }

    /** @test */
    public function email_should_be_valid_email()
    {
        $this->postJson('/api/register/client', ["email" => "1123_@a@.com.b"])
            ->assertStatus(400)
            ->assertJsonFragment(['email' => ['The email field must be a valid email address.']]);
    }

    /** @test */
    public function cpf_should_be_required()
    {
        $this->postJson('/api/register/client', [])->assertStatus(400)->assertJsonFragment(['cpf' => ["The cpf field is required."]]);
    }

    /** @test */
    public function cpf_should_be_unique()
    {

        Client::factory()->create(['cpf' => 98765432111]);
        $this->postJson('/api/register/client', ['cpf' => 98765432111])
        ->assertStatus(400)
        ->assertJsonFragment(["cpf" => ["CPF already registered."]]);
    }

    /** @test */
    public function birthdate_should_be_required()
    {
        $this->postJson('/api/register/client', [])->assertStatus(400)->assertJsonFragment(['birthdate' => ["The birthdate field is required."]]);
    }

    /** @test */
    public function phone_should_be_required()
    {
        $this->postJson('/api/register/client', [])->assertStatus(400)->assertJsonFragment(['phone' => ["The phone field is required."]]);
    }

}
