<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'assigned_user' => new UserResource($this->whenLoaded('assignedUser')),
            'assigned_user_id' => $this->assigned_user_id,
            'is_owner' => $request->user()->id === $this->user_id,
            'is_assigned' => $this->assigned_user_id === $request->user()->id
        ];
    }
}
