<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = $this->firstMedia ? asset('storage/images/products/' . $this->firstMedia->file_name) : null;
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'details' => $this->details,
            'image' => $image,
        ];
    }
}
