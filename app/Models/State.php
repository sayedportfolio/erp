<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'country_id',
        'state',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
