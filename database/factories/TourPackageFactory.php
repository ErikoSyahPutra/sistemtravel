<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\Destination;

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
            'price_minor' => $this->faker->numberBetween(500000, 5000000), // misal harga dalam rupiah
            'currency' => 'IDR', // bisa diganti atau ambil dari tabel currency
            'duration_days' => $this->faker->numberBetween(1, 10),
            'capacity' => $this->faker->numberBetween(5, 30),
            'images' => json_encode([
                $this->faker->imageUrl(640, 480, 'travel', true),
                $this->faker->imageUrl(640, 480, 'travel', true),
            ]),
            'extras' => json_encode([
                'meals' => $this->faker->boolean(),
                'insurance' => $this->faker->boolean(),
                'pickup' => $this->faker->boolean(),
            ]),
        ];
    }
}
