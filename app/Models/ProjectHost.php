<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHost extends Model
{
    protected $fillable = [
        'project_id',
        'host_name',
        'host_username',
        'host_password'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
