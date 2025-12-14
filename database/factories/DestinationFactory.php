<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class DestinationFactory extends Factory
{
    protected $model = \App\Models\Destination::class;

    public function definition()
    {
        $name = $this->faker->city();

        $images = [
            'destinations/destinations1.jpg',
            'destinations/destinations2.jpg',
            'destinations/destinations3.jpg',
            'destinations/destinations4.jpg',
            'destinations/destinations5.jpg',
        ];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'location' => $this->faker->country(),
            'description' => $this->faker->paragraph(2),
            'cover_image' => Arr::random($images),
            'meta' => json_encode([
                'keywords' => $this->faker->words(5, true),
                'rating' => $this->faker->randomFloat(1, 3, 5),
            ]),
        ];
    }
}
