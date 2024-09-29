<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentService
{

    public function getCommentsByTaskId($taskId)
    {
        try {
            // Fetch comments related to the task_id
            return Comment::where('task_id', $taskId)
            ->orderBy('created_at', 'desc')
            ->get();
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            throw $e;
        }
    }
    
    public function createComment($data)
    {
        $validator = Validator::make($data, [
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'author_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors(), 'status' => 400];
        }

        try {
            $comment = Comment::create($data);
            return ['data' => $comment, 'status' => 200];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), 'status' => 500];
        }
    }

    public function deleteComment($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return ['status' => 200, 'message' => 'Comment deleted successfully'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), 'status' => 500];
        }
    }
}
