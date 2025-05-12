<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandardStep extends Model
{
    protected $fillable = ['name', 'description', 'default_assignee_role', 'default_duration', 'notification_settings', 'buttons'];
    protected $casts = ['notification_settings' => 'array', 'buttons' => 'array'];
}
