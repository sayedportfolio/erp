<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'dob',
        'gender',
        'phone',
        'email',
        'aadhar_number',
        'address',
        'pan_number',
        'bank_account_number',
        'bank_ifsc_code',
        'aadhar_certificate',
        'pan_cerificate',
        'image',
        'user_id',
        'city_id',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class);
    }
}
