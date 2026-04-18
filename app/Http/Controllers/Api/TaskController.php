<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Services\ExternalApiService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function index(Request $request)
    {
        $tasks = $this->taskService->list($request->all());

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create($request->validated());

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->taskService->update($task, $request->validated());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $this->taskService->delete($task);

        return response()->json(null, 204);
    }

    public function suggestion(Task $task, ExternalApiService $externalService)
    {
        $suggestion = $externalService->getSuggestion();

        return response()->json([
            'task' => new TaskResource($task),
            'suggestion' => [
                'title' => $suggestion['title'] ?? null,
                'body' => $suggestion['body'] ?? null,
            ]
        ]);
    }
}