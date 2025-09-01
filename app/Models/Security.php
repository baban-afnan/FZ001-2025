<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_pin',
        'otp',
        'otp_expires_at',
        'security_question_1',
        'security_answer_1',
        'security_question_2',
        'security_answer_2',
        'security_question_3',
        'security_answer_3',
        'security_question_4',
        'security_answer_4',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
