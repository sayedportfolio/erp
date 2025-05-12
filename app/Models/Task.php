<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'task_id';
    protected $fillable = ['title', 'assignee', 'status', 'workflow_id', 'due_date', 'task_data'];
    protected $casts = ['task_data' => 'array'];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function assigneeUser()
    {
        return $this->belongsTo(User::class, 'assignee');
    }
}
