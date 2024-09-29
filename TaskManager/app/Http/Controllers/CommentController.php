<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index($task_id)
    {
        try {
            // Use the service to get comments
            $comments = $this->commentService->getCommentsByTaskId($task_id);

            return response()->json([
                'status' => 200,
                'message' => 'Comments retrieved successfully',
                'data' => $comments,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while retrieving comments',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $result = $this->commentService->createComment($request->all());
        if (isset($result['error'])) {
            return response()->json([
                'status' => $result['status'],
                'message' => 'Validation error',
                'errors' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'status' => $result['status'],
            'message' => 'Comment created successfully',
            'data' => $result['data'],
        ]);
    }

    public function destroy($id)
    {
        $result = $this->commentService->deleteComment($id);

        if (isset($result['error'])) {
            return response()->json([
                'status' => $result['status'],
                'message' => 'Error deleting comment',
                'error' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Comment deleted successfully',
        ]);
    }
}
