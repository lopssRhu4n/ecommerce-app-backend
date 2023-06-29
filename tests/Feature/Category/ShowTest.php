<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function it_should_be_possible_to_retrieve_single_category_data()
    {
        // arrange

        $categoryData =
            [
                'name' => 'test category',
                'description' => 'Created for testing'
            ];

        $category = Category::factory()->create($categoryData);

        $category->products;

        // act
        $response = $this->getJson('/api/category/1');

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($category) {
            $json->whereAll($category->toArray());
        });

        // assert
    }
}
