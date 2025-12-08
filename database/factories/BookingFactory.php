<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\TourPackage;
use App\Models\Currency; // Pastikan model Currency ada
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        // Logika tanggal: Start date acak, End date beberapa hari setelahnya
        $startDate = $this->faker->dateTimeBetween('now', '+3 months');
        $duration = $this->faker->numberBetween(3, 7);
        $endDate = Carbon::instance($startDate)->addDays($duration);

        $pax = $this->faker->numberBetween(1, 5);
        $pricePerPax = $this->faker->numberBetween(1000000, 5000000);
        $totalPrice = $pax * $pricePerPax;

        return [
            // Laravel akan otomatis membuat User & Package baru jika tidak disediakan di seeder
            'user_id' => User::factory(),
            'package_id' => TourPackage::factory(),

            'booking_number' => 'BOOK-' . strtoupper(Str::random(10)),
            'date_start' => $startDate,
            'date_end' => $endDate,
            'pax_count' => $pax,
            'total_price' => $totalPrice,
            'total_amount' => $totalPrice, // Asumsi sama dengan total_price

            // Ambil currency code yang ada atau default IDR
            'currency' => Currency::inRandomOrder()->first()->code ?? 'IDR',

            'status' => $this->faker->randomElement(['confirmed',]),
            'payment_status' => 'paid',
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'credit_card', null]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}
