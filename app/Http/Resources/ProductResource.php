<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $request['category.parent'] = $this->resource->category->parent;
        $request['tags'] = $this->resource->tags;
        $request['photos'] = $this->resource->photos;
        return parent::toArray($request);
    }
}
