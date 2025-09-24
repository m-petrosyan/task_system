<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public static function index(
        string $status = '',
        ?string $text = null,
        int|null $userId = null,
    ): Collection {
        return Task::query()
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($text, function ($query) use ($text) {
                $query->where(function ($q) use ($text) {
                    $q->where('title', 'LIKE', "%{$text}%")
                        ->orWhere('description', 'LIKE', "%{$text}%");
                });
            })
            ->when($userId, fn($query) => $query->where('assigned_user_id', $userId))
            ->orderBy('id', 'desc')
            ->with('assignedUser')
            ->get();
    }
}