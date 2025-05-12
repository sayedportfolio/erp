<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class smsGetway extends Model
{
    protected $fillable = [
        'branch_id',
        'url',
        'key',
        'sender_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
