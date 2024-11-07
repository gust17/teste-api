<?php

namespace App\Services\Contracts;

use App\Models\Task;

interface TaskServiceInterface
{
    public function listTasks();
    public function getTaskById(int $id): Task;
    public function createTask(array $data): Task;
    public function updateTask(Task $task, array $data): Task;
    public function deleteTask(Task $task): bool;
}
