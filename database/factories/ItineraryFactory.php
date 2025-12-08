<?php

namespace Database\Factories;

use App\Models\Itinerary;
use App\Models\TourPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItineraryFactory extends Factory
{
    protected $model = Itinerary::class;

    public function definition(): array
    {
        return [
            'package_id' => TourPackage::factory(),
            'day_number' => $this->faker->numberBetween(1, 4),
            'title' => $this->faker->randomElement(['Penjemputan Bandara', 'Wisata Pantai', 'Makan Siang', 'Check-in Hotel']),
            'description' => $this->faker->sentence(),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'location' => $this->faker->address(),
        ];
    }
}
