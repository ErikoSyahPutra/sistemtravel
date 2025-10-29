<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition()
    {
        // Ambil user dengan role guide yang belum punya guide
        $user = User::where('role', 'guide')
            ->whereDoesntHave('guide')
            ->inRandomOrder()
            ->first();

        return [
            'user_id' => $user ? $user->id : User::factory()->create(['role' => 'guide'])->id,
            'languages' => $this->faker->randomElements(['English', 'Indonesian', 'Japanese', 'French', 'Spanish'], 2),
            'bio' => $this->faker->paragraph(2),
            'available' => $this->faker->boolean(80), // 80% chance available
            'rating_cache' => $this->faker->randomFloat(1, 0, 5),
        ];
    }
}
