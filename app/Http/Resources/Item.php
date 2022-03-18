<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $items = [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'attributes' => $this->attributes,
            'conditions' => $this->conditions,
            'product' => new Product($this->associatedModel),
        ];

        return $items;
    }
}
