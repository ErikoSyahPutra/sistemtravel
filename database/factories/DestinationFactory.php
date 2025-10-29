<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DestinationFactory extends Factory
{
    protected $model = \App\Models\Destination::class;

    public function definition()
    {
        $name = $this->faker->city();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'location' => $this->faker->country(),
            'description' => $this->faker->paragraph(2),
            'cover_image' => null, // bisa diisi path gambar dummy nanti
            'meta' => json_encode([
                'keywords' => $this->faker->words(5, true),
                'rating' => $this->faker->randomFloat(1, 0, 5),
            ]),
        ];
    }
}
