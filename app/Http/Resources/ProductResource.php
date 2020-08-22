<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $request['category.parent'] = $this->resource->category->parent;
        $request['tags'] = $this->resource->tags;
        $request['photos'] = $this->resource->photos;
        $request['colors'] = $this->resource->colors;
        $request['sizes'] = $this->resource->sizes;
        return parent::toArray($request);
    }
}
