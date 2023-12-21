<?php

namespace Controllers\Api;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    public function testGetAllProductsApiEndpoint()
    {
        $response = $this->get('/api/products/');
        $result = json_decode($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
        $this->assertEquals('Product list has been retrieved.', $result->message);
    }

    public function testGetProductDetailsApiEndpoint()
    {
        $product = Product::factory()->create();

        $response = $this->get('/api/products/' . $product->id);
        $result = json_decode($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
        $this->assertEquals('Product info has been retrieved.', $result->message);
    }

    public function testCreateProductApiEndpoint()
    {
        $response = $this->post('/api/products', [
            'name' => fake()->unique()->name(),
            'description' => fake()->text,
            'price' => fake()->randomNumber(),
        ]);
        $result = json_decode($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->assertEquals('Product has been created.', $result->message);
    }

    public function testUpdateProductApiEndpoint()
    {
        $product = Product::factory()->create();
        $newProductName = fake()->unique()->name();
        $newProductDescription = fake()->text;
        $newPrice = mt_rand(1, 1000 * pow(10, 2)) / pow(10, 2);

        $response = $this->put('/api/products/' . $product->id, [
            'name' => $newProductName,
            'description' => $newProductDescription,
            'price' => $newPrice,
        ]);
        $result = json_decode($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->assertEquals('Product has been updated.', $result->message);
        $this->assertEquals($newProductName, $result->data->name);
        $this->assertEquals($newProductDescription, $result->data->description);
        $this->assertEquals($newPrice, $result->data->price);
    }

    public function testDeleteProductApiEndpoint()
    {
        $product = Product::factory()->create();

        $response = $this->delete('/api/products/' . $product->id);
        $result = json_decode($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->assertEquals('Product has been deleted.', $result->message);
        $this->assertNull(Product::find($product->id));
    }

    public function testCreateProductDataValidation()
    {
        $response = $this->post('/api/products', [
            'name' => null,
            'description' => null,
            'price' => null,
        ]);
        $result = json_decode($response->getContent());
        $errorMessages = $result->data;

        $response->assertStatus(500);

        $this->assertEquals('Invalid product data input.', $result->message);
        $this->assertContains('Product name is required', $errorMessages->name);
        $this->assertContains('Product description is required', $errorMessages->description);
        $this->assertContains('Product price is required', $errorMessages->price);
    }

    public function testCreateProductDuplicateNameValidation()
    {
        $product = Product::factory()->create();

        $response = $this->post('/api/products', [
            'name' => $product->name,
            'description' => 'test description',
            'price' => 99.99,
        ]);
        $result = json_decode($response->getContent());

        $response->assertStatus(500);
        $this->assertEquals('Product name already exists.', $result->message);
    }

    public function testUpdateOnNonExistentProductValidation()
    {
        $nonExistingProductId = Product::all()->pluck('id')->last() + 1;
        $response = $this->put('/api/products/' . $nonExistingProductId, [
            'name' => 'test name',
            'description' => 'test description',
            'price' => 99.99,
        ]);
        $result = json_decode($response->getContent());

        $response->assertStatus(500);
        $this->assertEquals('Product does not exists.', $result->message);
    }

    public function testDeleteOnNonExistentProductValidation()
    {
        $nonExistingProductId = Product::all()->pluck('id')->last() + 1;
        $response = $this->delete('/api/products/' . $nonExistingProductId);
        $result = json_decode($response->getContent());

        $response->assertStatus(500);
        $this->assertEquals('Product does not exists.', $result->message);
    }
}
