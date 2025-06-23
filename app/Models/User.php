<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
        'rating',
        'total_reviews',
        'completed_orders_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'rating' => 'decimal:1',
    ];

    public function updateRating()
    {
        // Hanya untuk traveler
        if ($this->role !== 'traveler') {
            return;
        }

        $completedOrders = $this->ordersAsTraveler()->where('status', 'completed')->whereNotNull('customer_rating');

        $totalRating = $completedOrders->sum('customer_rating');
        $totalReviews = $completedOrders->count();
        $completedOrdersCount = $this->ordersAsTraveler()->where('status', 'completed')->count();

        $this->update([
            'rating' => $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : null,
            'total_reviews' => $totalReviews,
            'completed_orders_count' => $completedOrdersCount,
        ]);
    }

    // Accessor untuk rating display
    public function getRatingDisplayAttribute()
    {
        return $this->role === 'traveler' ? ($this->rating ?? 5.0) : null;
    }

    public function travelerProfile()
    {
        return $this->hasOne(TravelerProfile::class);
    }

    public function ordersAsCustomer()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function ordersAsTraveler()
    {
        return $this->hasMany(Order::class, 'traveler_id');
    }

    // Alias untuk compatibility
    public function customerOrders()
    {
        return $this->ordersAsCustomer();
    }

    public function travelerOrders()
    {
        return $this->ordersAsTraveler();
    }

    // Alias untuk welcome blade
    public function customer()
    {
        return $this;
    }

    // Role check methods
    public function isCustomer()
    {
        return $this->role === 'penitip';
    }

    public function isTraveler()
    {
        return $this->role === 'traveler';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Metode baru untuk memeriksa apakah traveler sudah diverifikasi
    public function isTravelerVerified()
    {
        return $this->isTraveler() && $this->travelerProfile && $this->travelerProfile->verification_status === 'verified';
    }
}
