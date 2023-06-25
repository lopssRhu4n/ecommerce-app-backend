<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function it_should_be_possible_to_create_new_user()
    {
        $userData = [
            "name" => "Test User",
            "email" => "test@user.com",
            "password" => "12345678"
        ];

        // act

        $response = $this->postJson("/api/user/", $userData);
        // assert

        $response->assertStatus(201);
    }
}
