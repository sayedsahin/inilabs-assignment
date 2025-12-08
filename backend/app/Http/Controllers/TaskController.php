<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use App\Http\Resources\TaskResource;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    protected TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;

    }

    /**
     * Display a listing of tasks.
     */
    public function index()
    {
        $perPage = request()->input('per_page', 20);

        $tasks = $this->service->getPaginated($perPage);
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created task.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->service->create($request->validated());
        return new TaskResource($task);
    }

    /**
     * Display a specific task.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return new TaskResource($task);
    }

    /**
     * Update an existing task.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $updatedTask = $this->service->update($task, $request->validated());
        return new TaskResource($updatedTask);
    }

    /**
     * Delete a task.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->service->delete($task);

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}
