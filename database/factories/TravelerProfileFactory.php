<?php

namespace Database\Factories;

use App\Models\TravelerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelerProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TravelerProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $destinations = ['jakarta', 'bandung', 'surabaya', 'yogyakarta', 'bali', 'medan', 'makassar', 'semarang'];
        $specialties = ['fashion', 'skincare', 'elektronik', 'makanan', 'buku', 'beauty', 'accessories'];

        return [
            'travel_schedule' => fake()->randomElement([
                'Jepang, ' . now()->addMonths(1)->format('d M') . ' - ' . now()->addMonths(1)->addDays(10)->format('d M Y'),
                'Korea Selatan, ' . now()->addMonths(2)->format('d M') . ' - ' . now()->addMonths(2)->addDays(7)->format('d M Y'),
                'Singapura, ' . now()->addDays(15)->format('d M') . ' - ' . now()->addDays(20)->format('d M Y'),
                'Thailand, ' . now()->addMonths(1)->format('d M') . ' - ' . now()->addMonths(1)->addDays(14)->format('d M Y'),
            ]),
            'travel_purpose' => fake()->randomElement([
                'Belanja oleh-oleh dan elektronik.',
                'Hunting fashion dan skincare terbaru.',
                'Mencari produk unik dan limited edition.',
                'Business trip sekaligus belanja.',
            ]),
            'verification_status' => fake()->randomElement(['pending', 'verified', 'rejected']),
            'rating' => fake()->randomFloat(1, 4.0, 5.0),
            'bio' => fake()->text(200),
            'travel_destinations' => fake()->randomElements($destinations, fake()->numberBetween(2, 5)),
            'specialties' => fake()->randomElements($specialties, fake()->numberBetween(2, 4)),
            'available_for_orders' => fake()->boolean(80), // 80% chance true
            'bank_name' => fake()->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI', 'CIMB']),
            'bank_account_number' => fake()->numerify('##########'),
            'bank_account_name' => fake()->name(),
        ];
    }

    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'verification_status' => 'verified',
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'verification_status' => 'pending',
        ]);
    }
}
