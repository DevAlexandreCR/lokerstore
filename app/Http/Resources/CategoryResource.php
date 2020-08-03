<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $request['parent'] = $this->resource->parent;
        $request['children'] = $this->resource->children;
        $request['products'] = $this->resource->products;
        return parent::toArray($request);
    }
}
