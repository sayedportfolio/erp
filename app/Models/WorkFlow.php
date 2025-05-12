<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = ['template_id', 'name', 'steps', 'start_date', 'parent_workflow_id', 'parent_step_id', 'trigger_conditions', 'context_data'];
    protected $casts = ['steps' => 'array', 'trigger_conditions' => 'array', 'context_data' => 'array'];

    public function template()
    {
        return $this->belongsTo(WorkflowTemplate::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
