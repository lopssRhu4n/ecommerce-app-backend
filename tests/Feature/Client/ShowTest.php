<?php

namespace Tests\Feature\Client;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->seed();

        Sanctum::actingAs(
            User::factory()->createOne()
        );

        $response = $this->getJson('/api/client/1');

        $response->assertStatus(200);

        $response->assertJsonPath('id', 1);
    }
}
