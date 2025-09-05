<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BvnPhoneSearch extends Model
{
    protected $fillable = [
        'user_id',
        'tnx_id',
        'refno',
        'phone_number',
        'name',
        'status',
        'reason',
        'refunded_at',
        'performed_by',
        'approved_by',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'tnx_id');
    }
}
