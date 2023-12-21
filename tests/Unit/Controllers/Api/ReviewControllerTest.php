<?php

namespace Controllers\Api;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewControllerTest extends TestCase
{
    public function testCreateProductReviewApiEndpoint()
    {
        $product = Product::factory()->create();
        $response = $this->post('/api/products/' . $product->id . '/reviews', [
            'user_name' => fake()->userName(),
            'comment' => fake()->realText,
            'rating' => 4,
        ]);
        $result = json_decode($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->assertEquals('Product review has been created.', $result->message);
    }

    public function testCreateProductReviewDataValidation()
    {
        $product = Product::factory()->create();
        $response = $this->post('/api/products/' . $product->id . '/reviews', [
            'user_name' => null,
            'comment' => null,
            'rating' => null,
        ]);
        $result = json_decode($response->getContent());
        $errorMessages = $result->data;

        $response->assertStatus(500)
            ->assertJsonStructure(['success', 'data', 'message']);

        $this->assertEquals('Invalid product review data input.', $result->message);
        $this->assertContains('Product review comment is required', $errorMessages->comment);
        $this->assertContains('Product review rating is required', $errorMessages->rating);
        $this->assertContains('Product review username is required', $errorMessages->user_name);
    }

    public function testCreateProductReviewOnNonExistentProductValidation()
    {
        $nonExistingProductId = Product::all()->pluck('id')->last() + 1;

        $response = $this->post('/api/products/' . $nonExistingProductId . '/reviews', [
            'user_name' => fake()->userName(),
            'comment' => fake()->realText,
            'rating' => 4,
        ]);
        $result = json_decode($response->getContent());

        $response->assertStatus(500);
        $this->assertEquals('Product does not exists.', $result->message);
    }
}
