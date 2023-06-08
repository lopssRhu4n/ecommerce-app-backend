<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected $testUrl;


    public function setUp(): void
    {
        parent::setUp();

        $this->testUrl =  "/api/product/create";
    }


    /** @test */
    public function it_should_be_able_to_create_product()
    {
        // arrange
        Category::factory()->createOne();

        $user = User::factory()->createOne();
        $productData = Product::factory(1)->makeOne()->toArray();

        $this->actingAs($user);

        // act

        $response = $this->postJson($this->testUrl, $productData);

        // assert


        $response->assertStatus(201);
        $this->assertDatabaseHas('products', $productData);

        $response->assertJson(function (AssertableJson $json) use ($productData) {

            $json->whereAll([
                'created' => true,
                'product.name' => $productData['name'],
                'product.description' => $productData['description'],
                'product.price' => $productData['price'],
                'product.category_id' => $productData['category_id'],
                'product.sales' => $productData['sales'],
                'product.likes' => $productData['likes'],
            ]);
        });
    }

    /** @test */
    public function it_should_display_erros_when_product_properties_are_not_send()
    {

        $user = User::factory()->createOne();

        $this->actingAs($user);

        $this->postJson($this->testUrl, [])
            ->assertStatus(400)
            ->assertJsonFragment(["name" => ["The name field is required."]]);
    }

    /** @test */
    public function it_should_be_able_to_upload_product_image()
    {
        // arrange
        Storage::fake('s3');

        Category::factory()->createOne();
        $user = User::factory()->createOne();
        $this->actingAs($user);

        // act
        $this->post($this->testUrl, [
            "name" => "productImgTest",
            "description" => "TestingProductImg",
            "price" => 20.00,
            "category_id" => 1,
            "likes" => 0,
            "sales" => 0,
            "image" => UploadedFile::fake()->image("product1.png")
        ]);

        // assert

        Storage::disk('s3')->assertExists('product/product1.png');

        $this->assertDatabaseHas('products', [
            'image' => 'product/product1.png'
        ]);
    }

    /** @test */
    public function it_should_return_error_if_image_is_invalid_type()
    {
        Storage::fake('s3');

        Category::factory()->createOne();
        $user = User::factory()->createOne();
        $this->actingAs($user);

        // act
        $this->post($this->testUrl, [
            "name" => "productInvalidImgTest",
            "description" => "TestingInvalidProductImg",
            "price" => 20.00,
            "category_id" => 1,
            "likes" => 0,
            "sales" => 0,
            "image" => UploadedFile::fake()->image("product1.pdf")
        ])
            ->assertStatus(400)
            ->assertJsonFragment(["image" => ["The image field must be a file of type: png, jpg, jpeg, gif.", "The image field must be an image."]]);

        // assert
    }
}
