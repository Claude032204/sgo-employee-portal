<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginIdCounter extends Model
{
    protected $fillable = [
        'date_key',
        'last_number',
    ];
}