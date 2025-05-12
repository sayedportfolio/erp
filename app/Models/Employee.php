<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'dob',
        'gender',
        'phone',
        'email',
        'designation',
        'department',
        'joining_date',
        'last_qualification',
        'aadhar_number',
        'pan_number',
        'bank_account_number',
        'bank_ifsc_code',
        'qualification_certificate',
        'aadhar_certificate',
        'pan_cerificate',
        'image',
        'user_id',
        'branch_id',
        'city_id',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
