<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskIndexRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Requests\Task\TaskUpdateStatusRequest;
use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\Task\TasksStatusResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected TaskService $taskService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskIndexRequest $request): ResourceCollection
    {
        return TasksStatusResource::collection(TaskStatusEnum::values());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateRequest $request): Response
    {
        $this->taskService->store($request->validated());

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        return new TaskResource($task->load('assignedUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task): Response
    {
        $this->authorize('owner', $task);

        $this->taskService->update($task, $request->validated());

        return response()->noContent();
    }

    public function updateStatus(TaskUpdateStatusRequest $request, Task $task): Response
    {
        $this->authorize('assigned', $task);

        $this->taskService->updateStatus($task, $request->validated());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): Response
    {
        $this->authorize('owner', $task);

        $this->taskService->delete($task);

        return response()->noContent();
    }
}
