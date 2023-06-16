<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_delete_a_product()
    {

        $this->seed();

        $response = $this->deleteJson('/api/product/delete/1');

        // assert

        $response->assertStatus(200);
    }
}
