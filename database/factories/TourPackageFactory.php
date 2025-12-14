<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\Itinerary;

class TourPackageFactory extends Factory
{
    protected $model = \App\Models\TourPackage::class;

    public function definition()
    {
        $title = $this->faker->sentence(3);
        $destination = Destination::inRandomOrder()->first();

        return [
            'destination_id' => $destination ? $destination->id : Destination::factory()->create()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(2),
            'price' => $this->faker->numberBetween(500000, 5000000), // misal harga dalam rupiah
            'currency' => 'IDR', // bisa diganti atau ambil dari tabel currency
            'duration_days' => $this->faker->numberBetween(1, 10),
            'capacity' => $this->faker->numberBetween(5, 30),
            'images' => json_encode([
                $this->faker->randomElement([
                    'packages/package1.jpg',
                    'packages/package2.jpg',
                    'packages/package3.jpg',
                ]),
                $this->faker->randomElement([
                    'packages/package1.jpg',
                    'packages/package2.jpg',
                    'packages/package3.jpg',
                ]),
            ]),
            'extras' => json_encode([
                'meals' => $this->faker->boolean(),
                'insurance' => $this->faker->boolean(),
                'pickup' => $this->faker->boolean(),
            ]),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (TourPackage $package) {
            // Otomatis buat 3 Itinerary berurutan setiap kali Paket dibuat
            Itinerary::factory()
                ->count(3)
                ->state(new Sequence(
                    ['day_number' => 1, 'title' => 'Penjemputan & City Tour'],
                    ['day_number' => 2, 'title' => 'Wisata Utama'],
                    ['day_number' => 3, 'title' => 'Drop Bandara']
                ))
                ->create(['package_id' => $package->id]);
        });
    }
}
