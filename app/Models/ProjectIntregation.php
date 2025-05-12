<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectIntregation extends Model
{
    protected $fillable = [
        'project_id',
        'url',
        'username',
        'password',
        'key',
        'index',
        'token'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
