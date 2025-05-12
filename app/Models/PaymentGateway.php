<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentGateway extends Model
{
    protected $fillable = ['name', 'api_key', 'secret_key', 'branch_id', 'status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
