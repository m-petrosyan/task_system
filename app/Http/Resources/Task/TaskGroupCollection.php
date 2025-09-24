<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class TaskGroupCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return Collection
     */
    public function toArray($request): Collection
    {
        return $this->resource->map(fn($item, $key) => TaskResource::collection($item));
    }
}
