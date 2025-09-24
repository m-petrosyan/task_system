<?php

namespace App\Services;

use App\Models\Task;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Notification;

class TaskService
{
    public function store(array $attributes): Task
    {
        $task = auth()->user()->tasks()->create($attributes);

        Notification::send($task->assignedUser, new TaskAssignedNotification($task, 'New task assigned:'));

        return $task;
    }

    public function update(Task $task, array $attributes): void
    {
        $task->update($attributes);
    }

    public function updateStatus(Task $task, array $attributes): void
    {
        Notification::send($task->user, new TaskAssignedNotification($task, 'Task status updated:'));

        $this->update($task, $attributes);
    }


    public function delete(Task $task): void
    {
        $task->delete();
    }
}