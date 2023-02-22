<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'user_id' => $this->user_id,
            'shopping_session' => new CartResource($this->whenLoaded('shoppingSession')),
            'total_discount' => $this->total_discount,
            'user_address' => new UserAddressResource($this->whenLoaded('userAddress')),
        ];
    }
}
