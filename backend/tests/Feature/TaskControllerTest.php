<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Cria um usuário para autenticação se necessário
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('senha@123'),
        ]);
    }

    public function testCanCreateTask()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Task description',
            'status' => 'pending',
            'deadline' => now()->addDays(2)->toISOString(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function testCanListTasks()
    {
        Task::factory()->create(['title' => 'Test Task']);

        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Test Task']);
    }

    public function testCanShowTask()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $task->title]);
    }

    public function testCanUpdateTask()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'status' => 'completed',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['title' => 'Updated Task']);
    }

    public function testCanDeleteTask()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);
        $this->assertDeleted($task);
    }
}
