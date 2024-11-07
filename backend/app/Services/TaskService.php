<?php

namespace App\Services;

use App\Models\Task;
use App\Services\Contracts\TaskServiceInterface;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class TaskService implements TaskServiceInterface
{
    public function listTasks(): Collection
    {
        return Task::where('user_id', Auth::id())->get();
    }

    public function getTaskById(int $id): Task
    {
        return Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    }

    public function createTask(array $data): Task
    {
        $data['user_id'] = Auth::id();
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        if ($task->user_id === Auth::id()) {
            $task->update($data);
        }
        return $task;
    }

    public function deleteTask(Task $task): bool
    {
        return $task->user_id === Auth::id() ? $task->delete() : false;
    }


    public function fileReport($fileName)
    {
        $path = "reports/{$fileName}";

        if (Storage::disk('private')->exists($path)) {
            $file = Storage::disk('private')->get($path);
            return response($file, 200)
                ->header('Content-Type', Storage::disk('private')->mimeType($path));
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
