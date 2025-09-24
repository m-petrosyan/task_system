<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->data['message'] ?? null,
            'task_id' => $this->data['task_id'] ?? null,
            'status' => $this->data['status'] ?? null,
            'due_at' => $this->data['due_at'] ?? null,
        ];
    }
}
