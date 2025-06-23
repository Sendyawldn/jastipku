<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $destinations = [
            'jakarta',
            'bandung',
            'surabaya',
            'yogyakarta',
            'semarang',
            'malang',
            'solo',
            'denpasar',
            'medan',
            'palembang',
            'makassar'
        ];

        $categories = ['fashion', 'skincare', 'elektronik', 'makanan', 'buku', 'beauty', 'accessories'];

        $products = [
            'Tas Korea Brand Terkenal',
            'Skincare Jepang Limited Edition',
            'Gadget Tech Terbaru',
            'Sepatu Nike Original',
            'Parfum Import Original',
            'Buku Bestseller Import',
            'Snack Korea Viral',
            'Aksesoris Fashion Unik',
            'Elektronik Portable',
            'Makeup Korea Trending'
        ];

        return [
            'customer_id' => User::factory(),
            'traveler_id' => null,
            'nama_barang' => fake()->randomElement($products),
            'deskripsi' => fake()->paragraph(3),
            'kategori' => fake()->randomElement($categories),
            'budget' => fake()->numberBetween(500000, 5000000),
            'destination' => fake()->randomElement($destinations),
            'deadline' => fake()->dateTimeBetween('+1 week', '+2 months'),
            'status' => fake()->randomElement(['pending', 'accepted', 'in_progress', 'completed']),
            'catatan_khusus' => fake()->sentence(),
            'link_produk' => fake()->url(),
            'alamat_pengiriman' => fake()->address(),
            'no_telepon' => fake()->phoneNumber(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
            'traveler_id' => null,
        ]);
    }

    public function accepted(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'accepted',
            'traveler_id' => User::factory()->traveler(),
            'accepted_at' => now(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'completed',
            'traveler_id' => User::factory()->traveler(),
            'accepted_at' => now()->subDays(10),
            'completed_at' => now()->subDays(2),
            'ongkos_jasa' => fake()->numberBetween(100000, 500000),
            'total_belanja' => fake()->numberBetween(500000, 2000000),
            'total_pembayaran' => fake()->numberBetween(600000, 2500000),
            'payment_status' => 'paid',
        ]);
    }
}
