<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['task_id', 'author_name', 'content'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}