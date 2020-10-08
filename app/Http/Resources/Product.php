<?php

namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;
   
class Product extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'discription' => $this->detail,
            'price' => $this->price,
            'prodType' => $this->prodType,
            'qtn' => $this->stock == 0 ? 'Out of stock' : $this->stock,
            'category' => $this->cat,
            'brand' => $this->brandName,
            'rating' => $this->reviews->count() > 0 ? rand($this->reviews->sum('star')/$this->reviews->count(),2) : 'No review yet.',
            'image1' => $this->img1,
            'image2' => $this->img2,
            'image3' => $this->img3,
            'image4' => $this->img4,
            'sku' => $this->sku,
            'color' => $this->maincolor,
            'size' => $this->size,
            'discount' => $this->discount,
            // 'sellerId' => $this->id
            'href' => [
                'reviews' => route('reviews.index',$this->id),
            ]
        ];
    }
}
