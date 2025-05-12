<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'branch_id',
        'client_id',
        'project_category_id',
        'regular_project_id',
        'project_manager_id',
        'type',
        'name',
        'description',
        'budget',
        'start_date',
        'expected_end_date',
        'completed_date',
        'delay',
        'payment_type',
        'cost',
        'paid',
        'due',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }
}
