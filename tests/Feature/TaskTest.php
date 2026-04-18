<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_create_task()
    {
        $user = \App\Models\User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/tasks', [
                'title' => 'Test task',
                'description' => 'Test description',
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'Test task'
            ]);
    }

    public function test_can_list_tasks()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        \App\Models\Task::factory()->count(3)->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_show_task()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $task = \App\Models\Task::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $task->id
            ]);
    }

    public function test_returns_404_if_task_not_found()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/tasks/999');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Resource not found'
            ]);
    }

    public function test_validation_error_on_create()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/tasks', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }
}
