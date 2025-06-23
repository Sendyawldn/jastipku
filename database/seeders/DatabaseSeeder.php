<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\TravelerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::factory()->create([
            'name' => 'Admin JastipKu',
            'email' => 'admin@jastipku.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Membuat 1 user Penitip spesifik untuk login
        $penitip = User::factory()->create([
            'name' => 'Penitip User',
            'email' => 'penitip@example.com',
            'role' => 'penitip',
            'password' => Hash::make('12345678'),
        ]);

        // Membuat 1 user Traveler spesifik untuk login
        $traveler = User::factory()->traveler()->create([
            'name' => 'Traveler User',
            'email' => 'traveler@example.com',
            'password' => Hash::make('12345678'),
        ]);

        // Membuatkan profil untuk traveler spesifik tsb
        TravelerProfile::factory()->verified()->create([
            'user_id' => $traveler->id,
        ]);

        // Membuat 5 user penitip lainnya
        User::factory(5)->create();

        // Membuat 5 user traveler lainnya secara acak
        User::factory(5)->traveler()->create()->each(function ($user) {
            TravelerProfile::factory()->create(['user_id' => $user->id]);
        });

        // Membuat 10 pesanan pending untuk user penitip spesifik
        Order::factory(10)->pending()->create([
            'customer_id' => $penitip->id,
        ]);

        // Membuat beberapa pesanan random dari user lain
        $allCustomers = User::where('role', 'penitip')->get();
        foreach ($allCustomers as $customer) {
            Order::factory(fake()->numberBetween(2, 5))->pending()->create([
                'customer_id' => $customer->id,
            ]);
        }

        // Membuat beberapa pesanan yang sudah selesai
        Order::factory(10)->completed()->create();
    }
}
