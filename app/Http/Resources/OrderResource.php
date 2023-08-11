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
            'createdAt' => $this->created_at,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'name' => $this->name,
            'delivered' => $this->delivered == 0 ? false : true,
            'items' => OrderItemResource::collection($this->items)
        ];
    }
}
