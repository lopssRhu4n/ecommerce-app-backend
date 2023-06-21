<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test */
    public function it_should_be_possible_to_logout_when_authenticated_with_token(): void
    {
        $user = User::factory()->createOne();

        $token = $user->createToken('auth')->plainTextToken;

        $response = $this->withHeaders(["Authorization" => "Bearer $token"])->deleteJson('/api/logout');

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'Token was deleted successfully.']);

        $this->assertEquals($user->tokens()->get()->toArray(), []);
    }
}
