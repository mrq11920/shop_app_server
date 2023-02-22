<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LargeCategoryResource extends JsonResource
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
            'icon' => $this->icon,
            'small_categories' => SmallCategoryResource::collection($this->whenLoaded('small_categories')),
        ];
    }
}
