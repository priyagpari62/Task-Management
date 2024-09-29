<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TaskService
{
    public function listTasks($request)
    {
        $query = Task::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by due date range
        if ($request->has('due_date')) {
            $query->where('due_date', $request->due_date);
        }
        
        $query->orderBy('id', 'desc');

        return $query->paginate(10);
    }

    public function createTask($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,in-progress,todo,completed,pending,under-review',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors(), 'status' => 400];
        }

        try {
            $task = Task::create($data);
            return ['data' => $task, 'status' => 200];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), 'status' => 500];
        }
    }

    public function getTaskById(int $id)
    {
        // Use findOrFail to throw an exception if the task is not found
        $task = Task::findOrFail($id);

        // Format the created_at attribute
        $task->createdDate = Carbon::parse($task->created_at)->format('d/m/y');
        $task->status = ucfirst($task->status);
        return $task;
    }

    public function updateTask($data, $id)
    {
        $validator = Validator::make($data, [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,in-progress,todo,completed,pending,under-review',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors(), 'status' => 400];
        }

        try {
            $task = Task::findOrFail($id);
            $task->update($data);

            return ['data' => $task, 'status' => 200];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), 'status' => 500];
        }
    }

    public function deleteTask($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return ['status' => 200, 'message' => 'Task deleted successfully'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), 'status' => 500];
        }
    }
}
