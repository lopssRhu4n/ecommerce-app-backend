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
        $return = $this->post(route('client/register'), [
            'name' => $name,
            'email' => $email,
            'cpf' => $cpf,
            'birthdate' => $birthdate,
            'phone' => $phone
        ]);


        //Assert
        $return->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'cpf' => $cpf,
            'birthdate' => $birthdate,
            'phone' => $phone

        ]);
    }
}
