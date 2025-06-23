<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'traveler_id',
        'nama_barang',
        'deskripsi',
        'kategori',
        'budget',
        'destination',
        'deadline',
        'status',
        'catatan_khusus',
        'link_produk',
        'foto_produk',
        'ongkos_jasa',
        'ongkos_jasa_otomatis', // Tambahkan ini
        'total_belanja',
        'total_pembayaran',
        'payment_status',
        'metode_pembayaran',
        'alamat_pengiriman',
        'no_telepon',
        'metode_pengiriman',
        'resi_pengiriman',
        'accepted_at',
        'completed_at',
        'customer_rating',
        'customer_review',
        'cancel_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'deadline' => 'date',
        'budget' => 'decimal:2',
        'ongkos_jasa' => 'decimal:2',
        'ongkos_jasa_otomatis' => 'decimal:2', // Tambahkan ini
        'total_belanja' => 'decimal:2',
        'total_pembayaran' => 'decimal:2',
        'foto_produk' => 'array',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'customer_rating' => 'integer',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function traveler()
    {
        return $this->belongsTo(User::class, 'traveler_id');
    }

    // Photos accessor
    public function getPhotosAttribute()
    {
        return $this->foto_produk ?? [];
    }

    public function hasPhotos()
    {
        return !empty($this->foto_produk);
    }

    // Payment method display
    public function getPaymentMethodDisplayAttribute()
    {
        $methods = [
            'bank_transfer' => '🏦 Transfer Bank',
            'ewallet' => '📱 E-Wallet',
            'virtual_account' => '💳 Virtual Account',
            'qris' => '📲 QRIS',
            'cash_on_delivery' => '💵 COD',
        ];

        return $methods[$this->metode_pembayaran] ?? $this->metode_pembayaran;
    }

    // Category display
    public function getCategoryDisplayNameAttribute()
    {
        $categoryNames = [
            'fashion' => '👗 Fashion & Pakaian',
            'skincare' => '🧴 Skincare & Kosmetik',
            'elektronik' => '📱 Elektronik',
            'makanan' => '🍎 Makanan & Minuman',
            'buku' => '📚 Buku & Majalah',
            'beauty' => '💄 Beauty & Health',
            'accessories' => '👜 Accessories',
            'toys' => '🧸 Mainan & Hobi',
            'sports' => '⚽ Olahraga',
            'home' => '🏠 Rumah Tangga',
            'lainnya' => '📦 Lainnya'
        ];

        return $categoryNames[$this->kategori] ?? ucfirst($this->kategori);
    }

    // Accessor untuk menampilkan ongkos jasa (pilih ongkos_jasa jika ada, jika tidak, ongkos_jasa_otomatis)
    public function getDisplayOngkosJasaAttribute()
    {
        return $this->ongkos_jasa ?? $this->ongkos_jasa_otomatis;
    }


    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByDestination($query, $destination)
    {
        return $query->where('destination', $destination);
    }

    public function scopeByCategory($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
