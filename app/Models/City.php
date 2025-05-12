<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'city',
        'pin_code',
        'state_id',
        'city',
        'status'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
