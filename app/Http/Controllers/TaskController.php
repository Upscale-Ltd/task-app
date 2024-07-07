<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

// #devmode
class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $tasks = $this->user()->tasks()->get();

        return TaskResource::collection($tasks);
    }

    public function update(TaskUpdateRequest $request, Task $task): TaskResource
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return TaskResource::make($task->fresh());
    }

    public function store(TaskStoreRequest $request): TaskResource
    {
        $task = $this->user()->tasks()->create($request->only([
            'description',
            'deadline',
        ]));

        return TaskResource::make($task);
    }
}
