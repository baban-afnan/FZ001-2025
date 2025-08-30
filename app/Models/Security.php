<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Security extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'pin', 'otp', 
        'otp_expires_at'
    
    ];
}
