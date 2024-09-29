<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $result = $this->taskService->listTasks($request);

        return response()->json([
            'status' => 200,
            'message' => 'Tasks fetched successfully',
            'data' => $result,
        ]);
    }

    public function store(Request $request)
    {
        $result = $this->taskService->createTask($request->all());

        if (isset($result['error'])) {
            return response()->json([
                'status' => $result['status'],
                'message' => 'Validation error',
                'errors' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'status' => $result['status'],
            'message' => 'Task created successfully',
            'data' => $result['data'],
        ]);
    }

    public function show($id)
    {
        try {
            // Fetch the task using the service
            $task = $this->taskService->getTaskById($id);
            return response()->json([
                'status' => 200,
                'message' => 'Task fetched successfully',
                'data' => $task,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Task not found',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the task',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        $result = $this->taskService->updateTask($request->all(), $id);

        if (isset($result['error'])) {
            return response()->json([
                'status' => $result['status'],
                'message' => 'Error updating task',
                'errors' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'status' => $result['status'],
            'message' => 'Task updated successfully',
            'data' => $result['data'],
        ]);
    }

    public function destroy($id)
    {
        $result = $this->taskService->deleteTask($id);

        if (isset($result['error'])) {
            return response()->json([
                'status' => $result['status'],
                'message' => 'Error deleting task',
                'error' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Task deleted successfully',
        ]);
    }
}
