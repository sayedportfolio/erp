<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegulerProject extends Model
{
    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'cost'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
