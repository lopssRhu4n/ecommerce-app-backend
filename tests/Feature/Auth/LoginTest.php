<?php

namespace Tests\Feature\Auth;

use App\Models\Cart;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_login_with_right_credentials()
    {
        // arrange
        $user = User::factory()->create([
            'email' => 'teste@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        Client::factory()->createOne();
        Cart::factory()->create(['client_id' => 1, 'amount' => 0, 'shipping' => 0, 'discount' => 0]);
        // act

        $response = $this->postJson('/api/login', ['email' => 'teste@gmail.com', 'password' => '12345678']);

        // assert


        $userToken = $user->tokens()->get()->toArray()[0];

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas(
            'personal_access_tokens',
            [
                "id" => $userToken['id'],
                "tokenable_id" => $userToken['tokenable_id']
            ]
        );
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

        $response = $this->postJson('/api/login', ['email' => $credentials['email'], 'password' => 'Not passing']);
        // assert

        $response
            ->assertStatus(404)
            ->assertJsonFragment(['Error' => "Passwords don't match!"]);
    }

    /** @test */
    public function it_should_not_be_able_to_request_guarded_route_without_token()
    {
        // arrange


        // act


        $response = $this->getJson('/api/client/1');


        // assert

        $response
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }

    /** @test */
    public function it_should_be_able_to_request_guarded_route_with_valid_token()
    {
        // arrange

        $this->seed();
        $user = User::factory()->createOne();

        $token = $user->createToken('auth')->plainTextToken;
        // act

        $response = $this->withHeaders([
            "Authorization" => "Bearer $token"
        ])->getJson('/api/client/1');
        // assert

        $response
            ->assertStatus(200)
            ->assertJsonPath('client.id', 1);
    }
}
