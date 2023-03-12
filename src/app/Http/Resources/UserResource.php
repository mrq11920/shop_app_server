<?php

namespace App\Http\Resources;

use App\Models\UserAddress;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'role' => $this->role,
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'addresses' => UserAddressResource::collection($this->whenLoaded('addresses')),
        ];
    }
}
