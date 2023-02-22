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
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'price' => $this->price,
            'unit_type' => $this->unit_type,
            'quantity' => $this->quantity,
            'category' => new SmallCategoryResource($this->whenLoaded('category')),
            'province' => new ProvinceResource($this->whenLoaded('province')),
        ];
    }
}
