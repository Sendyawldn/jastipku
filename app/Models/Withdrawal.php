<?php
// app/Models/Withdrawal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'processed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
