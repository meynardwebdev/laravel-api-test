<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'user_name' => $this->user_name,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => (new \DateTime($this->created_at))->format('d/m/Y'),
            'updated_at' => $this->updated_at ? (new \DateTime($this->updated_at))->format('d/m/Y') : null,
        ];
    }
}
