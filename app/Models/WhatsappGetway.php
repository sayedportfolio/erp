<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappGetway extends Model
{
    protected $fillable = [
        'branch_id',
        'url',
        'key',
        'sid',
        'phone_number'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
