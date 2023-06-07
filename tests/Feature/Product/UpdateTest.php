<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_update_a_product()
    {
        $user = User::factory()->createOne();
        $this->actingAs($user);

        $this->seed();

        // act

        $response = $this->putJson('api/product/update/1', [
            "name" => "Changed",
            "description" => "For update test",
        ]);

        $updatedProduct = Product::where('id', 1)->first();
        // assert

        $response->assertStatus(204);
        $this->assertEquals('Changed', $updatedProduct->name);
        $this->assertEquals('For update test', $updatedProduct->description);
    }
}
