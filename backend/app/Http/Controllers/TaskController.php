<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Jobs\GenerateTaskReport;
use App\Jobs\SendTaskNotification;
use App\Services\Contracts\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->listTasks();
        return TaskResource::collection($tasks);
    }

    public function show($id)
    {
        $task = $this->taskService->getTaskById($id);
        return new TaskResource($task); 
    }

    public function store(TaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());
        SendTaskNotification::dispatch($task);

        return (new TaskResource($task))->response()->setStatusCode(201);
    }

    public function update(TaskRequest $request, $id)
    {
        $task = $this->taskService->getTaskById($id);
        $task = $this->taskService->updateTask($task, $request->validated());
        return new TaskResource($task);
    }

    public function destroy($id)
    {
        $task = $this->taskService->getTaskById($id);
        $this->taskService->deleteTask($task);
        return response()->json(null, 204);
    }

    public function generateReport(): JsonResponse
    {
        GenerateTaskReport::dispatch(auth()->user());
        return response()->json(['message' => 'A geração do relatório foi iniciada. Você receberá um e-mail quando estiver pronto.']);
    }

    public function getFileReport($fileName)
    {
        return $this->taskService->fileReport($fileName);
    }


}
