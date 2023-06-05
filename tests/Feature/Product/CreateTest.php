<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        $this->actingAs($user);

        $testProductData = [
            "name" => "Produto de Teste",
            "description" => "Produto criado para fins de teste",
            "price" => 100.00,
            "category_id" => 1,
            "likes" => 0,
            "sales" => 0
        ];

        // act

        $response = $this->post($this->testUrl, $testProductData);

        // assert


        $response->assertStatus(201);
        $this->assertDatabaseHas('products', $testProductData);
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
            ->assertStatus(400);

        // assert
    }
}
