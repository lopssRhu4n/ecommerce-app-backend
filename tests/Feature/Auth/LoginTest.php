<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_login_with_right_credentials()
    {
        // arrange
        User::factory()->create([
            'email' => 'teste@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        // act

        $response = $this->postJson('/api/login', ['email' => 'teste@gmail.com', 'password' => '12345678']);

        // assert

        $response->assertStatus(200);

    }

    /** @test */
    public function it_should_display_error_when_user_is_not_found()
    {
        // arrange
        $credentials = ['email' => 'notindb@notindb.com', 'password' => 'aaaaa'];

        // act
        $response = $this->postJson('/api/login', $credentials);


        // assert
        $response
            ->assertStatus(404)
            ->assertJsonFragment(["Error" => "User not found!"]);
    }

    /** @test */
    public function it_should_display_error_with_incorrect_password()
    {
        $credentials = ['email' => 'teste@gmail.com', 'password' => Hash::make('12345678')];
        User::factory()->create($credentials);

        // act

        $response = $this->postJson('/api/login', [ 'email' => $credentials['email'], 'password' => 'Not passing']);
        // assert

        $response
            ->assertStatus(404)
            ->assertJsonFragment(['Error' => "Passwords don't match!"]);



    }
}
