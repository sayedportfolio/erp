<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{

    protected $fillable = [
        'organization_name',
        'address',
        'pin_code',
        'client_id',
        'city_id',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
