<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowTemplate extends Model
{
    protected $fillable = ['name', 'steps'];
    protected $casts = ['steps' => 'array'];
}
