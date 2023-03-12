<?php

namespace App\Http\Resources;

use App\Models\SmallCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'merchant_id' => $this->merchant_id,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'price' => $this->price,
            'unit_type' => $this->unit_type,
            'quantity' => $this->quantity,
            'small_category_id' => $this->small_category_id,
            'small_category' => new SmallCategoryResource($this->whenLoaded('smallCategory')),
            'large_category_id' => $this->large_category_id,
            'large_category' => new LargeCategoryResource($this->whenLoaded('largeCategory')),
            'province_id' => $this->province_id,
            'province' => new ProvinceResource($this->whenLoaded('province')),
        ];
    }
}
