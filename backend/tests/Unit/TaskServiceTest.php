<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Contracts\TaskServiceInterface;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $taskService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskService = app(TaskServiceInterface::class);
    }

    public function testCanCreateTask()
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Task description',
            'status' => 'pending',
            'deadline' => now()->addDays(2),
        ];

        $task = $this->taskService->createTask($taskData);
        $this->assertDatabaseHas('tasks', $taskData);
        $this->assertInstanceOf(Task::class, $task);
    }

    public function testCanUpdateTask()
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $updatedData = [
            'title' => 'Updated Task',
            'status' => 'completed',
        ];

        $this->taskService->updateTask($task, $updatedData);
        $this->assertDatabaseHas('tasks', array_merge($updatedData, ['id' => $task->id]));
    }

    public function testCanDeleteTask()
    {
        $task = Task::factory()->create();

        $this->taskService->deleteTask($task);
        $this->assertDeleted($task);
    }
}
