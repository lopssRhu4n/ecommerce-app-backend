<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

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
        $this->postJson('/api/register/client', ['email' => 'xablau@email.com'])
            ->assertStatus(400)
            ->assertJsonFragment(['email' => ['Email should be unique']]);
    }

    /** @test */
    public function cpf_should_be_required()
    {
        $this->postJson('/api/register/client', [])->assertStatus(400)->assertJsonFragment(['cpf' => ["The cpf field is required."]]);
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

    // /** @test */
    // public function it_should_be_able_to_show_registered_user()
    // {
    //     //act
    //     $response = $this->getJson('api/client/1');
    //
    //     //assert
    //     $response->assertStatus(200);
    // }
}
