<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_update_a_product()
    {
        $user = User::factory()->createOne();
        $this->actingAs($user);

        $this->seed();
        $id = 1;
        $updateData = ["name" => "Changed", "description" => "For update test"];

        $response = $this->putJson("api/product/update/1", $updateData);

        $product = Product::query()->find($id)->toArray();

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', $updateData);

        $response->assertJson(function (AssertableJson $json) use ($product) {
            $json->whereAll([
                'name' => $product['name'],
                'description' => $product['description']
            ])
                ->etc();
        });
    }
}
