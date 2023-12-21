<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\Review as ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class ProductController extends BaseController
{
    /**
     * Retrieve a list of products with their reviews.
     *
     * @return JsonResponse
     */
    public function index()
    {
        // Get all products
        $products = Product::with('reviews')->get();

        return $this->sendResponse(ProductResource::collection($products), 'Product list has been retrieved.');
    }

    /**
     * Retrieve a single product with its reviews.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product does not exists.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product info has been retrieved.');
    }

    /**
     * Create a new product.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        try {
            $product = Product::create($validated);
        } catch (UniqueConstraintViolationException $e) {
            return $this->sendError('Product name already exists.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product has been created.');
    }

    /**
     * Update an existing product.
     *
     * @param StoreProductRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreProductRequest $request, $id)
    {
        $validated = $request->validated();
        $product = Product::find($id);

        if (!$product) {
            return $this->sendError('Product does not exists.');
        }

        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product has been updated.');
    }

    /**
     * Delete a product.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->sendError('Product does not exists.');
        }

        $product->delete();

        return $this->sendResponse([], 'Product has been deleted.');
    }
}
