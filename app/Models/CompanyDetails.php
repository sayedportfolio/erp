<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'pin_code',
        'city_id',
        'status'
    ];

    public function barnches()
    {
        return $this->hasMany(Branch::class);
    }
}
