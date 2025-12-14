<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating_package' => $this->faker->numberBetween(3, 5),
            'comment_package' => $this->faker->paragraph(2),

            'rating_guide' => $this->faker->boolean(80) ? $this->faker->numberBetween(4, 5) : null,
            'comment_guide' => $this->faker->boolean(60) ? $this->faker->sentence() : null,

            'review_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
