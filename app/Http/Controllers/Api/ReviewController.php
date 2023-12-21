<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\Review as ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends BaseController
{

    /**
     * Create a review for a specific product.
     *
     * @param int $id
     * @param StoreReviewRequest $request
     * @return JsonResponse
     */
    public function __invoke($id, StoreReviewRequest $request)
    {
        $validated = $request->validated();
        $product = Product::find($id);

        if (!$product) {
            return $this->sendError('Product does not exists.');
        }

        $validated['product_id'] = $id;

        $review = Review::create($validated);

        return $this->sendResponse(new ReviewResource($review), 'Product review has been created.');
    }
}
