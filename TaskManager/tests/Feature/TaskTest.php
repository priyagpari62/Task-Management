<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskCreation()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'New Task',
            'description' => 'Task Description',
            'status' => 'pending',
            'due_date' => '2024-12-31'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Task created successfully'
            ]);
    }
}
