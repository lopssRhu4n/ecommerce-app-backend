<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->seed();

        $count = Category::all()->count();

        $response = $this->getJson('/api/category');

        $response->assertStatus(200);
        $response->assertJsonCount($count);

    }
}
