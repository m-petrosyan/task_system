<?php

namespace App\Http\Resources\Task;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->status && $request->status !== $this->resource) {
            return [
                'status' => $this->resource,
                'data' => TaskResource::collection([]),
            ];
        }
        return [
            'status' => $this->resource,
            'data' => TaskResource::collection(TaskRepository::index(
                $this->resource,
                $request->text,
                $request->user_id,
            )),
        ];
    }
}
