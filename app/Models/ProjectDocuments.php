<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocuments extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'file'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
