<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'company_detail_id',
        'code',
        'name',
        'phone',
        'email',
        'address',
        'pin_code',
        'city_id',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(CompanyDetails::class, 'company_detail_id');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
