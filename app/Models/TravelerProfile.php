<?php
// p/app/Models/TravelerProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik', // Tambahkan ini
        'id_card_path',
        'travel_schedule',
        'travel_purpose',
        'verification_status',
        'rating',
        'bio',
        'travel_destinations',
        'specialties',
        'available_for_orders',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'withdrawn_amount',
    ];

    protected $casts = [
        'travel_destinations' => 'array',
        'specialties' => 'array',
        'available_for_orders' => 'boolean',
        'rating' => 'decimal:1',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}