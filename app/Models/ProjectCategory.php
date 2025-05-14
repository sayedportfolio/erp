<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'min_cost',
        'status',
    ];
}
